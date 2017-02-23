<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
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
      dd($project);
    }

    public function prepareBaseApp()
    {
      if (is_file(storage_path('app/public/demo/package.json'))) {
         dd("File exists");
      }
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
