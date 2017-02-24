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
      return view(
        'project/edit/index',
        compact('projectName')
      );
    }

    public function delete($projectName)
    {
      // Deleting Resources
      $currentUser = Auth::user()->email;
      Storage::deleteDirectory('projects/'.$currentUser.'/'.$projectName);
      return redirect()->route('projects');
    }

    public function lists()
    {
      $currentUser = Auth::user()->email;
      $listProject = Storage::directories('projects/'.$currentUser.'/');
      return $listProject;
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
