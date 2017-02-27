<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;

class DeveloperController extends Controller
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
        if (Auth::user()->role != 1) {
          return redirect()->route('frontpage');
        }
        return view('developer.index');
    }

    public function updateIonicTemplate()
    {
      $template = array(
        'active' => $this->templateVersion,
        'GITHUB_APP_ID' => env('GITHUB_APP_ID'),
        'GITHUB_APP_SECRET' => env('GITHUB_APP_SECRET'),
        'GITHUB_APP_OWNER' => env('GITHUB_APP_OWNER'),
        'GITHUB_APP_REPO' => env('GITHUB_APP_REPO'),
        'GITHUB_APP_ARCHIVE_FORMAT' => env('GITHUB_APP_ARCHIVE_FORMAT'),
        'GITHUB_APP_TAG' => env('GITHUB_APP_TAG'),
      );

      $client = new \GuzzleHttp\Client();
      $res = $client->request(
        'GET',
        'https://api.github.com/repos/'.$template['GITHUB_APP_OWNER'].'/'.$template['GITHUB_APP_REPO'].'/tags?client_id='.$template['GITHUB_APP_ID'].'&client_secret='.$template['GITHUB_APP_SECRET']
      );
      $headerType = $res->getHeaderLine('content-type');
      $content = $res->getBody();

      $json = json_decode($content);
      $zipball = $client->request(
        'GET',
        $json[0]->zipball_url
      );
      $zipContent = $zipball->getBody();

      // dd($zipball);
      Storage::put('github/latest.zip', $zipContent);
      // foreach ($json as $tag) {
      //   if (is_file()) {
      //     # code...
      //   }
      // }

      return $content;
    }

    public function getActiveTemplateInfo()
    {
      $template = array(
        'active' => $this->templateVersion,
        'GITHUB_APP_ID' => env('GITHUB_APP_ID'),
        'GITHUB_APP_SECRET' => env('GITHUB_APP_SECRET'),
        'GITHUB_APP_OWNER' => env('GITHUB_APP_OWNER'),
        'GITHUB_APP_REPO' => env('GITHUB_APP_REPO'),
        'GITHUB_APP_ARCHIVE_FORMAT' => env('GITHUB_APP_ARCHIVE_FORMAT'),
        'GITHUB_APP_TAG' => env('GITHUB_APP_TAG'),
      );
      return json_encode($template, JSON_FORCE_OBJECT);
    }


    public function parseXML(Request $request) {

      // Reading Uploaded XML File
      $xmlSource = $request->file('xmlfile');
      // Store XML File in Storage Folder
      $xmlPath = $request->file('xmlfile')->store('xml', 'public');

      // Parsing XML File
      $xmlDocument = new \DOMDocument('1.0', 'utf-8');
      $xmlDocument->load(storage_path('app/public/').$xmlPath);
      $xPath = new \DOMXPath($xmlDocument);

      if ($xPath->query('/elements')->length > 0) {
        $rootElement = '/elements/unit';
      }else {
        $rootElement = '/unit';
      }

      // Generating HTML Template with XML file
      $htmlTemplate = self::getTemplate($xPath);

      // Saving HTML file for testing
      Storage::put('public/html/test.html', $htmlTemplate, 'public');

      // Deleting XML File after Parsing Completed
      Storage::delete('public/'.$xmlPath);

      // Testing
      self::generateIonicPreview($htmlTemplate);

      return view('developer.xml.validator', compact('rootElement', 'xPath', 'htmlTemplate'));
    }

    public function getTemplate($xPath) {
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

    public function generateIonicPreview($fileContent) {

      self::prepareBaseApp();

      $html = Storage::get('ionic/'.$this->templateVersion.'/src/pages/question/question.html');

      $html = str_replace(
        [
          '{{myappcontent}}'
        ],
        [
          $fileContent
        ],
        $html
      );
      // Saving HTML file for testing
      Storage::put('public/demo/src/pages/question/question.html', $html, 'public');
    }

    public function prepareBaseApp()
    {
      // if (is_file(storage_path('app/public/demo/package.json'))) {
      //    dd("File exists");
      // }
      Storage::deleteDirectory('public/demo/');
      $appSourceFiles = Storage::allFiles('ionic/'.$this->templateVersion);
      Storage::makeDirectory('public/demo/');
      foreach ($appSourceFiles as $file) {
        $fileName = explode('/', $file);
        $fileName = array_diff($fileName, ['ionic', $this->templateVersion]);
        $fileName = implode('/', $fileName);
        Storage::copy($file, 'public/demo/'.$fileName);
      }
    }


}
