<?php

namespace Omega\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;

class CreatePlugin extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'omega:plugin:create {plugin : The name of the plugin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a plugin with the given name';

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

    }

    protected function getStub()
    {
        // TODO: Implement getStub() method.
        return 'path/to/stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return 'OmegaPlugin\\';
    }

    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        $table = $this->option('table')? : str_plural(strtolower($this->getNameInput()));

        return $this
            ->replaceNamespace($stub, $name)
            ->replaceTable($stub, $table)
            ->replaceClass($stub, $name);
    }
    protected function replaceTable(&$stub, $table) {
        $stub = str_replace(
        '{{table}}', $table, $stub
        );

        return $this;
    }


    protected function getOptions()
    {
        return [

        ];
    }
}
