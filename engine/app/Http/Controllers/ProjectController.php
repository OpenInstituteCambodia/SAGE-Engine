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
      $project = array(
        'projectName' => $request->input('projectName'),
        'projectVersion' => $request->input('projectVersion'),
        'projectPackageName' => $request->input('projectPackageName'),
        'projectDescription' => $request->input('projectDescription'),
      );

      self::copyBaseApp($project);
      return redirect()->route('projects');

    }

    public function edit($projectName)
    {
      $currentUser = Auth::user()->email;
      // Parsing XML File
      $xmlDocument = new \DOMDocument('1.0', 'utf-8');
      $xmlDocument->load(storage_path('app/projects/'.$currentUser.'/'.$projectName.'/config.xml'));
      $xPath = new \DOMXPath($xmlDocument);

      $appID = $xPath->evaluate('string(/widget/@id)');

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
      return 'File Already Exists';

    }

}
