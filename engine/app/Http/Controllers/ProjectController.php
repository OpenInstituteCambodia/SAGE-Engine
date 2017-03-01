<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    // Specify Version of Template
    private $templateVersion;
    private $sage;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $SAGE = new SageController();
        $this->sage = $SAGE->sageConfig();
        $this->templateVersion = $this->sage['template'];
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userEmail = Auth::user()->email;
        $projects = self::lists();

        return view(
          'project.index',
          compact('projects', 'userEmail')
        );
    }

    public function create(Request $request)
    {
      $userEmail = Auth::user()->email;

      $project = array(
        'projectName' => $request->input('projectName'),
        'projectVersion' => $request->input('projectVersion'),
        'projectPackageName' => $request->input('projectPackageName'),
        'projectDescription' => $request->input('projectDescription'),
      );

      // 1. Copying Base Application to Project Folder
      self::copyBaseApp($project);

      // 2. Editing Config.xml and package.json data for project
      $xmlContent = Storage::get('projects/'.$userEmail.'/'.$project['projectName'].'/config.xml.example');
      $xmlContent = str_replace([
        '{{projectPackageName}}',
        '{{projectName}}',
        '{{projectDescription}}',
        '{{projectVersion}}',
        '{{userEmail}}',
      ], [
        $project['projectPackageName'],
        $project['projectName'],
        $project['projectDescription'],
        $project['projectVersion'],
        $userEmail

      ], $xmlContent);

      // 3. Saving Data back into Config.xml and package.json in Project Folder
      Storage::put('projects/'.$userEmail.'/'.$project['projectName'].'/config.xml', $xmlContent, 'public');

      return redirect()->route('projects');

    }

    public function edit($projectName)
    {
      $userEmail = Auth::user()->email;

      // Getting XML content to remove Namespace
      $content = Storage::get('projects/'.$userEmail.'/'.$projectName.'/config.xml');
      $content = str_replace([
        'xmlns="http://www.w3.org/ns/widgets" xmlns:cdv="http://cordova.apache.org/ns/1.0"'
      ], [
        'placeholder_xml_namespace="true"'
      ], $content);

      // Parsing XML File
      $xmlDocument = new \DOMDocument('1.0', 'utf-8');
      $xmlDocument->loadXML($content);
      // $xmlDocument->load(storage_path('app/projects/'.$userEmail.'/'.$projectName.'/config.xml'));
      $xPath = new \DOMXPath($xmlDocument);

      $project = array(
        'projectName' => $xPath->evaluate('string(/widget/name)'),
        'projectVersion' => $xPath->evaluate('string(/widget/@version)'),
        'projectPackageName' => $xPath->evaluate('string(/widget/@id)'),
        'projectDescription' => $xPath->evaluate('string(/widget/description)'),
      );

      if (is_file(storage_path('app/projects/'.$userEmail.'/'.$projectName.'/unit.xml'))) {
        $unit = Storage::get('projects/'.$userEmail.'/'.$projectName.'/unit.xml');
        $htmlQuestion = Storage::get('projects/'.$userEmail.'/'.$projectName.'/src/pages/question/question.html');
      }else {
        $unit = '';
      }
      $htmlMenu = '';


      return view(
        'project/edit/index',
        compact( 'project', 'unit', 'htmlMenu', 'htmlQuestion' )
      );
    }

    public function delete($projectName)
    {
      $userEmail = Auth::user()->email;
      // Deleting Resources
      Storage::deleteDirectory('projects/'.$userEmail.'/'.$projectName.'/', true);
      return redirect()->route('projects');
    }

    public function lists()
    {
      $userEmail = Auth::user()->email;
      $listProject = Storage::directories('projects/'.$userEmail.'/');
      return $listProject;
    }

    public function upload(Request $request)
    {
      $userEmail = Auth::user()->email;
      $projectName = $request->input('projectName');

      // Reading Uploaded XML File
      $xmlSource = $request->file('xmlfile');
      $xmlPath = $request->file('xmlfile')->store('xml', 'public');
      $xmlSource = Storage::get('public/'.$xmlPath);

      // Store XML File in Storage Folder
      $xmlPath = Storage::put('projects/'.$userEmail.'/'.$projectName.'/unit.xml', $xmlSource);

      // Parsing XML file to Generate HTML output
      self::parseXML($request);

      return redirect()->route('project.edit', [$projectName]);
    }

    public function copyBaseApp($p)
    {
      $userEmail = Auth::user()->email;
      if (!is_file(storage_path('app/projects/'.$userEmail.'/'.$p['projectName'].'/package.json'))) {

        Storage::makeDirectory('projects/'.$userEmail.'/'.$p['projectName']);

        $appSourceFiles = Storage::allFiles('ionic/'.$this->templateVersion);
        foreach ($appSourceFiles as $file) {
          $fileName = explode('/', $file);
          $fileName = array_diff($fileName, ['ionic', $this->templateVersion]);
          $fileName = implode('/', $fileName);
          Storage::copy($file, 'projects/'.$userEmail.'/'.$p['projectName'].'/'.$fileName);
        }
      }
      // return 'File Already Exists';

    }

    public function parseXML(Request $request) {
      // Saving HTML file for testing
      $userEmail = Auth::user()->email;
      $projectName = $request->input('projectName');

      // Reading Uploaded XML File
      $xmlSource = $request->file('xmlfile');
      // Store XML File in Storage Folder
      $xmlPath = 'projects/'.$userEmail.'/'.$projectName.'/unit.xml';

      // Parsing XML File
      $xmlDocument = new \DOMDocument('1.0', 'utf-8');
      $xmlDocument->load(storage_path('app/').$xmlPath);
      $xPath = new \DOMXPath($xmlDocument);

      if ($xPath->query('/elements')->length > 0) {
        $rootElement = '/elements/unit';
      }else {
        $rootElement = '/unit';
      }

      // Generating HTML Template with XML file
      $htmlTemplate = self::prepareHTML($xPath);

      // Reading HTML base Template HTML file for replacing content
      $htmlSource = Storage::get('ionic/'.$this->templateVersion.'/src/pages/question/question.html');

      $htmlFinalized = str_replace([
        '{{myappcontent}}'
      ], [
        $htmlTemplate
      ], $htmlSource);

      Storage::put('projects/'.$userEmail.'/'.$projectName.'/src/pages/question/question.html', $htmlFinalized);
      return redirect()->route('project.edit', [$projectName]);
    }

    public function prepareHTML($xPath)
    {
      if ($xPath->query('/elements')->length > 0) {
        $rootElement = '/elements/unit';
      }else {
        $rootElement = '/unit';
      }

      // Replacing Placeholder with XML Data
      $htmlOut = '';
      for ($i=1; $i <= $xPath->query($rootElement)->length; $i++) {

        $selectedStyle = $xPath->evaluate('string('.$rootElement.'['.$i.']/@style)');
        $t = Storage::get('templates/'.$this->templateVersion.'/'.$selectedStyle.'.html');

        // Question
        $t = str_replace([
            '{{placeholder_unit_id}}',
            '{{placeholder_text}}',
            '{{placeholder_pre_audio}}',
            '{{placeholder_audio}}',
            '{{placeholder_audio_image}}',
            '{{placeholder_text}}',
            '{{placeholder_correct_answer}}',
            '{{placeholder_wrong_answer}}',
            '{{placeholder_correct}}',
            '{{placeholder_next}}'
          ],[
            $xPath->evaluate('string('.$rootElement.'['.$i.']/@id)'),
            $xPath->evaluate('string('.$rootElement.'['.$i.']/text)'),
            $xPath->evaluate('string('.$rootElement.'['.$i.']/pre-audio)'),
            $xPath->evaluate('string('.$rootElement.'['.$i.']/audio)'),
            $xPath->evaluate('string('.$rootElement.'['.$i.']/image)'),
            $xPath->evaluate('string('.$rootElement.'['.$i.']/text)'),
            $xPath->evaluate('string('.$rootElement.'['.$i.']/correct_answer)'),
            $xPath->evaluate('string('.$rootElement.'['.$i.']/wrong_answer)'),
            $xPath->evaluate('string('.$rootElement.'['.$i.']/correct)'),
            $xPath->evaluate('string('.$rootElement.'['.$i.']/next)')
          ],
          $t);

        // Choices
        for ($c=1; $c <= $xPath->query($rootElement.'['.$i.']/choice')->length; $c++) {
          $t = str_replace([
            '{{placeholder_choice_'.$c.'_text}}',
            '{{placeholder_choice_'.$c.'_image}}',
            '{{placeholder_choice_'.$c.'_audio}}'
          ],[
            $xPath->evaluate('string('.$rootElement.'['.$i.']/choice['.$c.']/text)'),
            $xPath->evaluate('string('.$rootElement.'['.$i.']/choice['.$c.']/image)'),
            $xPath->evaluate('string('.$rootElement.'['.$i.']/choice['.$c.']/audio)')
          ], $t);
        }
        $htmlOut = $htmlOut.$t;
      }

      return $htmlOut;
    }

}
