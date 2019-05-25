<?php

namespace Omega\Console\Commands;

use Illuminate\Console\Command;
use Omega\Utils\Path;

class PluginShowDisplayView extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'omega:plugin:showdisplayviews {name : The name of the plugin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will show you a list with all "front-end" view of the plugin. These views can be overrided by component\'s templates in your theme.';

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
        $pluginName = trim($this->input->getArgument('name'));

        $pluginPath = plugin_path($pluginName);

        if(!file_exists($pluginPath) || !is_dir($pluginPath)) {
            $this->output->error('This plugin doesn\'t exists.');
            return 10;
        }

        $viewPath = Path::Combine($pluginPath, 'view');

        $views = array();
        if(file_exists($viewPath)){
            $dir = opendir ($viewPath);
            while($element = readdir($dir))
            {
                if(strpos($element, 'display_') === 0)
                {
                    if (!is_dir(Path::Combine($viewPath, $element)))
                        $views[] = $element;
                }
            }
            sort($views);
        }


        $this->output->writeln('');
        $this->line('Publishable views for the plugin ' . $pluginName . ' : ');
        foreach ($views as $file) {
            $this->info('   ' . without_ext(without_ext($file)));
        }
        $this->output->writeln('');

        $this->line('You can publish one of these view into your theme by typing the following command :');
        $this->output->writeln('');
        $this->info('   php artisan omega:theme:publish_plugin_view {themename} {pluginname} {viewname}');
        $this->output->writeln('');
    }
}
