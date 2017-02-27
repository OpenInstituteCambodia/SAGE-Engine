<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use App\Http\Controllers\NameGeneratorController;
use App\Http\Controllers\ProjectController;

class ProjectCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $generator = new NameGeneratorController();
      $projectManager = new ProjectController();

      $currentUser = $this->ask('Please provide User Email address:');
      $templateVersion = $this->ask('Please provide Template Version:');
      $numberOfProject = $this->ask('Number of Project to be generate:');


      for ($i=1; $i <= $numberOfProject; $i++) {
        $projectName = $generator->create();

        $p = array(
          'projectName' => $projectName,
          'projectVersion' => '',
          'projectPackageName' => '',
          'projectDescription' => '',
        );

        echo "Creating project -> ".$i." -> ".$projectName."\n";

        if (!is_file(storage_path('app/projects/'.$currentUser.'/'.$p['projectName'].'/package.json'))) {

          Storage::makeDirectory('projects/'.$currentUser.'/'.$p['projectName']);

          $appSourceFiles = Storage::allFiles('ionic/'.$templateVersion);
          foreach ($appSourceFiles as $file) {
            $fileName = explode('/', $file);
            $fileName = array_diff($fileName, ['ionic', $templateVersion]);
            $fileName = implode('/', $fileName);
            Storage::copy($file, 'projects/'.$currentUser.'/'.$p['projectName'].'/'.$fileName);
          }
        }
      }

    }
}
