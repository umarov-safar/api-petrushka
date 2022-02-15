<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name} {--folder=}';

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
     * @return int
     */
    public function handle()
    {
        $folder = $this->option('folder');

        $name = $this->argument('name');

        if($folder) {
            $dtoFilePath = app_path('Services/'. $folder . '/' . $name);
        } else {
            $dtoFilePath = app_path('Services/'. $name);
        }

        if(file_exists($dtoFilePath . '.php'))
        {
            $this->line("<fg=red;bg=black>File already exist!!.</>");
            return null;
        }

        $dtoFilePath = fopen($dtoFilePath . '.php', 'w');
        fwrite($dtoFilePath, $this->dataFile($name, $folder));
        fclose($dtoFilePath);

        $this->line('<fg=green;bg=black>You create successfully dto class!</>');
        return null;

    }


    public function dataFile(string  $name, string $folder = null) : string
    {
        $namespace = $folder ? "App\Services\\$folder" : "App\Services";
        return "<?php
namespace {$namespace};

class {$name} {

    //code

}";

    }

}
