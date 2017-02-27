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

      $userEmail = $this->ask('Please provide User Email address:');
      $templateVersion = $this->ask('Please provide Template Version:');
      $numberOfProject = $this->ask('Number of Project to be generate:');


      for ($i=1; $i <= $numberOfProject; $i++) {
        $projectName = $generator->create();

        $p = array(
          'projectName' => $projectName,
          'projectVersion' => '0.0.1',
          'projectPackageName' => 'debug.'.$projectName,
          'projectDescription' => $projectName.$projectName.$projectName.$projectName.$projectName.$projectName,
        );

        echo "Creating project -> ".$i." -> ".$projectName."\n";

        if (!is_file(storage_path('app/projects/'.$userEmail.'/'.$p['projectName'].'/package.json'))) {

          Storage::makeDirectory('projects/'.$userEmail.'/'.$p['projectName']);

          $appSourceFiles = Storage::allFiles('ionic/'.$templateVersion);
          foreach ($appSourceFiles as $file) {
            $fileName = explode('/', $file);
            $fileName = array_diff($fileName, ['ionic', $templateVersion]);
            $fileName = implode('/', $fileName);
            Storage::copy($file, 'projects/'.$userEmail.'/'.$p['projectName'].'/'.$fileName);

          }

          $xmlContent = Storage::get('projects/'.$userEmail.'/'.$p['projectName'].'/config.xml');
          $xmlContent = str_replace([
            '{{projectPackageName}}',
            '{{projectName}}',
            '{{projectDescription}}',
            '{{projectVersion}}',
            '{{userEmail}}',
          ], [
            $p['projectPackageName'],
            $p['projectName'],
            $p['projectDescription'],
            $p['projectVersion'],
            $userEmail

          ], $xmlContent);

          // 3. Saving Data back into Config.xml and package.json in Project Folder
          Storage::put('projects/'.$userEmail.'/'.$p['projectName'].'/config.xml', $xmlContent, 'public');
        }
      }

    }
}
