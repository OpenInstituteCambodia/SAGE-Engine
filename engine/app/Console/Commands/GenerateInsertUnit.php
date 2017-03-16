<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;
use Carbon\Carbon;

class GenerateInsertUnit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:unit {xmlPath : XML Path} {destPath? : (Optional) Destenation Path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate SQL Insert Statement for SQLite to Units Table';

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
    *  Constance Insert String 
    */
    private $insertTemplate = <<<EOF
INSERT INTO units( unit_id, unit_style, unit_content, unit_audio_1, unit_audio_2, choice_1_content, choice_1_audio, choice_2_content, choice_2_audio, choice_3_content, choice_3_audio, choice_4_content, choice_4_audio, choice_correct_id, choice_correct_audio, choice_wrong_audio) VALUES ( '{unit_id}', '{unit_style}', '{unit_content}', '{unit_audio_1}', '{unit_audio_2}', '{choice_1_content}', '{choice_1_audio}', '{choice_2_content}', '{choice_2_audio}', '{choice_3_content}', '{choice_3_audio}', '{choice_4_content}', '{choice_4_audio}', '{choice_correct_id}', '{choice_correct_audio}', '{choice_wrong_audio}');
EOF;
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        $xmlPath = $this->argument('xmlPath');
        $destPath = $this->argument('destPath');
        if (empty($destPath)){
            $current_time = Carbon::now()->timestamp;
            
            $destPath =  storage_path().'/insertUnitsScript_'.$current_time.'.sql';
        }
        if (!File::exists($xmlPath)){
            die("You file is not exist.");
        } else{
                if ($this->isValidXml($xmlPath)){
                
                $units=simplexml_load_file($xmlPath) or die("Error: Cannot create object");

                $bar = $this->output->createProgressBar(count($units));
                $sqlOut ='';
                foreach ($units->children() as $unit) {
                    $sqlOut .= $this->performGenerateInsert($unit);
                    $sqlOut .= "\n";
                    $bar->advance();
                }
                //Writing to file
                $bytes_written = File::put($destPath, $sqlOut);
                if ($bytes_written === false)
                {
                    die("Error writing to file");
                }
                echo $sqlOut;
                $bar->finish();
                echo " Completed!\n";
            }
        }
    }

    function isValidXml($content)
    {
        $content = trim($content);
        if (empty($content)) {
            return false;
        }
        if (stripos($content, '<!DOCTYPE html>') !== false) {
            return false;
        }

        libxml_use_internal_errors(true);
        simplexml_load_file($content);
        $errors = libxml_get_errors();          
        libxml_clear_errors();  

        return empty($errors);
    }

    function performGenerateInsert($unit){
        
        $output = str_replace(['{unit_id}', '{unit_style}', '{unit_content}',
                                        '{unit_audio_1}', '{unit_audio_2}',
                                        '{choice_correct_id}', '{choice_correct_audio}', '{choice_wrong_audio}'],
                         [$unit['id'], $unit['style'], $unit->{'audio-text'},
                         $unit->{'pre-audio'}, $unit->audio,
                         $unit->correct, $unit->correct_answer, $unit->wrong_answer],
                        $this->insertTemplate);

        $choices = $unit->choice;

        $output = str_replace(['{choice_1_content}', '{choice_1_audio}',
                                        '{choice_2_content}', '{choice_2_audio}',
                                        '{choice_3_content}', '{choice_3_audio}', 
                                        '{choice_4_content}', '{choice_4_audio}'],
                                        [$choices[0]->text, $choices[0]->audio,
                                        $choices[1]->text, $choices[1]->audio,
                                        $choices[2]->text, $choices[2]->audio,
                                        $choices[3]->text, $choices[3]->audio],
                                        $output);               

        return $output;
    }
}
