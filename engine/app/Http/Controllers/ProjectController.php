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
    private $templateVersion = 'v0.1';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentUser = Auth::user()->email;
        $projects = self::lists();
        return view(
          'project.index',
          compact('projects', 'currentUser')
        );
    }

    public function create(Request $request)
    {
      $currentUser = Auth::user()->email;

      $project = array(
        'projectName' => $request->input('projectName'),
        'projectVersion' => $request->input('projectVersion'),
        'projectPackageName' => $request->input('projectPackageName'),
        'projectDescription' => $request->input('projectDescription'),
      );

      // 1. Copying Base Application to Project Folder
      self::copyBaseApp($project);

      // 2. Editing Config.xml and package.json data for project
      $xmlContent = Storage::get('projects/'.$currentUser.'/'.$project['projectName'].'/config.xml');
      $xmlContent = str_replace([
        'xmlns="http://www.w3.org/ns/widgets" xmlns:cdv="http://cordova.apache.org/ns/1.0"',
        '{{projectPackageName}}',
        '{{projectName}}',
        '{{projectDescription}}',
        '{{projectVersion}}',
        '{{userEmail}}',
      ], [
        'placeholder_xml_namespace="true"',
        $project['projectPackageName'],
        $project['projectName'],
        $project['projectDescription'],
        $project['projectVersion'],
        $currentUser

      ], $xmlContent);

      // 3. Saving Data back into Config.xml and package.json in Project Folder
      Storage::put('projects/'.$currentUser.'/'.$project['projectName'].'/config.xml', $xmlContent, 'public');

      return redirect()->route('projects');

    }

    public function edit($projectName)
    {
      $currentUser = Auth::user()->email;

      // Getting XML content to remove Namespace
      $content = Storage::get('projects/'.$currentUser.'/'.$projectName.'/config.xml');
      $content = str_replace([
        'xmlns="http://www.w3.org/ns/widgets" xmlns:cdv="http://cordova.apache.org/ns/1.0"'
      ], [
        'placeholder_xml_namespace="true"'
      ], $content);

      // Parsing XML File
      $xmlDocument = new \DOMDocument('1.0', 'utf-8');
      $xmlDocument->loadXML($content);
      // $xmlDocument->load(storage_path('app/projects/'.$currentUser.'/'.$projectName.'/config.xml'));
      $xPath = new \DOMXPath($xmlDocument);

      $project = array(
        'projectName' => $xPath->evaluate('string(/widget/name)'),
        'projectVersion' => $xPath->evaluate('string(/widget/@version)'),
        'projectPackageName' => $xPath->evaluate('string(/widget/@id)'),
        'projectDescription' => $xPath->evaluate('string(/widget/description)'),
      );

      return view(
        'project/edit/index',
        compact('project' )
      );
    }

    public function delete($projectName)
    {
      $currentUser = Auth::user()->email;
      // Deleting Resources
      Storage::deleteDirectory('projects/'.$currentUser.'/'.$projectName);
      return redirect()->route('projects');
    }

    public function lists()
    {
      $currentUser = Auth::user()->email;
      $listProject = Storage::directories('projects/'.$currentUser.'/');
      return $listProject;
    }

    public function upload(Request $request)
    {
      # code...
    }

    public function copyBaseApp($p)
    {
      $currentUser = Auth::user()->email;
      if (!is_file(storage_path('app/projects/'.$currentUser.'/'.$p['projectName'].'/package.json'))) {

        Storage::makeDirectory('projects/'.$currentUser.'/'.$p['projectName']);

        $appSourceFiles = Storage::allFiles('ionic/'.$this->templateVersion);
        foreach ($appSourceFiles as $file) {
          $fileName = explode('/', $file);
          $fileName = array_diff($fileName, ['ionic', $this->templateVersion]);
          $fileName = implode('/', $fileName);
          Storage::copy($file, 'projects/'.$currentUser.'/'.$p['projectName'].'/'.$fileName);
        }
      }
      // return 'File Already Exists';

    }

    public function prepareXML()
    {
      # code...
    }

}
