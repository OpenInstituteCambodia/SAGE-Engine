<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class ProjectController extends Controller
{
    // Specify Version of Template
    private $templateVersion = 'v0.1';
    private $currentUser = 'socheat';

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
        return view('project.index');
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
      self::lists();
    }

    public function delete($p)
    {
      // Deleting Resources
      Storage::deleteDirectory('public/demo/');
    }

    public function lists()
    {
      $listProject = Storage::directories('projects/'.$this->currentUser.'/');
      dd($listProject);
    }

    public function copyBaseApp($p)
    {

      if (!is_file(storage_path('app/projects/'.$this->currentUser.'/'.$p['projectName'].'/package.json'))) {

        Storage::makeDirectory('projects/'.$this->currentUser.'/'.$p['projectName']);

        $appSourceFiles = Storage::allFiles('ionic/'.$this->templateVersion);
        foreach ($appSourceFiles as $file) {
          $fileName = explode('/', $file);
          $fileName = array_diff($fileName, ['ionic', $this->templateVersion]);
          $fileName = implode('/', $fileName);
          Storage::copy($file, 'projects/'.$this->currentUser.'/'.$p['projectName'].'/'.$fileName);
        }
      }
      return 'File Already Exists';

    }

}
