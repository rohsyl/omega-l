<?php

namespace Omega\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Omega\Repositories\PluginRepository;
use Omega\Utils\Path;

class PublishPluginAssets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'omega:plugin:publish
                        {plugin : The name of the plugin}
                        {--A|all : Publish all plugin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish the `assets` directory of the plugin to the `public` directory';

    private $pluginRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(PluginRepository $pluginRepository)
    {
        parent::__construct();

        $this->pluginRepository = $pluginRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $optAll = $this->option('all');


        // if --all option is defined, then publish all plugin's assets
        if($optAll != null){

            $this->info(__('Assets for all plugin will be published'));

            $code = Artisan::call('vendor:publish', [
                '--tag' => 'plugins',
                '--force' => true
            ]);

            $this->info(Artisan::output());

            return $code;
        }

        $pluginName = $this->argument('plugin');

        if($pluginName == null){
            $this->error(__('Missing argument...'));
            return 1;
        }

        $plugin = $this->pluginRepository->getByName($pluginName);

        if($plugin == null)
        {
            $this->error(__('This plugin does not exists or is not installed...'));
            return 2;
        }


        $publishTag = 'plugin:' . $plugin->name;

        $code = Artisan::call('vendor:publish', [
            '--tag' => $publishTag,
            '--force' => true
        ]);

        $this->info(Artisan::output());

        return $code;
    }
}
