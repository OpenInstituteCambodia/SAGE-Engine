<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

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
        return view('developer.index');
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
        ob_start();
          include(storage_path('app/templates/'.$this->templateVersion.'/'.$selectedStyle.'.html'));
        $t = ob_get_clean();

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

      ob_start();
        include(storage_path('app/ionic/'.$this->templateVersion.'/src/pages/question/question.html'));
      $html = ob_get_clean();

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
