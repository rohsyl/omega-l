<?php

namespace Omega\Console\Commands;

use Illuminate\Console\Command;
use Omega\Utils\Path;

class PluginCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'omega:plugin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a plugin with the given name';


    private $rawPluginName;

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
     * Execute the console command to generate a new plugin
     *
     * @return mixed
     */
    public function handle()
    {
        // Get the name of the plugin
        $pluginNameOk = false;
        do {
            $this->rawPluginName = $this->ask('Please provide a plugin name');

            $this->output->writeln('Plugin name must follow some rules and be formatted. After formatting, your plugin name will be :');
            $this->output->writeln('    ' . $this->getPluginUnderscoreCase());
            $this->output->writeln('');

            if($this->confirm('Do you want to keep this plugin name ?')){
                $pluginNameOk = true;
            }
        } while(!$pluginNameOk);

        // Check if a plugin with the same name exists
        if($this->pluginExists()){
            $this->output->error('A plugin with this name already exists. Please choose another name...');
            return 10;
        }

        // Create directory
        $this->createPath();
        $this->createPath('view');
        $this->createPath('assets');
        $this->createPath('assets/css');
        $this->createPath('assets/images');

        // Generate files
        $this->generateController('BController');
        $this->generateController('FController');
        $this->generateView('view/display', 'display');
        $this->generateStyle('assets/css/styles', 'styles');

        // Copy files
        $this->copyFile('assets/images/component-logo.png');

        // Generate plugin.json file
        $this->generateJson();

        $this->output->writeln('');
        $this->output->writeln('Plugin ' . $this->getPluginUnderscoreCase() . ' generated succesfully !');
    }

    /**
     * Get the stub of the given type
     *
     * @param $type string The type of the stub
     * @return false|string
     */
    protected function getStub($type) {
        return file_get_contents(resource_path("stubs/plugin/$type.stub"));
    }

    /**
     * Format the plugin name to camel case
     *
     * @return string The name of the plugin
     */
    protected function getPluginNameCamelCase(){
        return camelize_plugin($this->rawPluginName);
    }

    /**
     * Format the plugin name to camel case
     *
     * @return string The name of the plugin
     */
    protected function getPluginNameTitle(){
        return str_replace('_', ' ', ucwords($this->rawPluginName, '_'));
    }

    /**
     * Format the plugin name to underscorecase
     *
     * @return string The name of the plugin
     */
    protected function getPluginUnderscoreCase(){
        return snake_case($this->rawPluginName);
    }

    /**
     * Check if a plugin with the given name already exists
     *
     * @return bool True if exists
     */
    protected function pluginExists(){
        return file_exists(
            plugin_path(
                $this->getPluginUnderscoreCase()
            )
        );
    }

    /**
     * Create a directory in the plugin directory
     *
     * @param null $directory
     * @return bool
     */
    protected function createPath($directory = null){
        $path = plugin_path($this->getPluginUnderscoreCase());

        if(isset($directory)){
            $path = Path::Combine($path, $directory);
        }

        if (file_exists($path)) {
            return false;
        }

        mkdir($path, 0777, true);

        $this->output->writeln('Directory created : ' . $path);

        return true;
    }

    /**
     * Copy the given file from /ressources/stubs/plugin/ to /omega/plugin/[plugin_name]/
     *
     * @param $file string The file to copy
     */
    protected function copyFile($file){
        copy(resource_path('/stubs/plugin/' . $file), plugin_path($this->getPluginUnderscoreCase()) . '/' . $file);

        $this->output->writeln('File copied : ' . $file);
    }

    /**
     * Generate the plugin.json file
     */
    protected function generateJson() {

        $data = [
            'pluginName' => $this->getPluginUnderscoreCase(),
            'pluginTitle' => $this->getPluginNameTitle(),
            'pluginVersion' => '1.0.0',
            'author' => '',
            'authorMail' => '',
            'authorWebsite' => '',
            'description' => '',
            'options' => [
                    'displayInMenu' => 0
            ]
        ];

        $jsonString = json_encode($data, JSON_PRETTY_PRINT);

        $outputPath = plugin_path($this->getPluginUnderscoreCase()) . '/plugin.json';

        file_put_contents($outputPath, $jsonString);

        $this->output->writeln('File generated : ' . $outputPath);
    }

    /**
     * Generate the controller
     *
     * @param $type string BController|FController
     */
    protected function generateController($type){

        $controllerTemplate = str_replace(
            [
                '{{PluginName}}',
                '{{plugin_name}}',
            ],
            [
                $this->getPluginNameCamelCase(),
                $this->getPluginUnderscoreCase()
            ],
            $this->getStub($type)
        );

        $outputPath = plugin_path($this->getPluginUnderscoreCase()) . '/' .$type . $this->getPluginNameCamelCase() . '.php';

        file_put_contents($outputPath, $controllerTemplate);

        $this->output->writeln('File generated : ' . $outputPath);
    }

    /**
     * Generate view
     *
     * @param $type
     * @param $name
     */
    protected function generateView($type, $name) {

        $viewTemplate = str_replace(
            [
                '{{PluginName}}',
            ],
            [
                $this->getPluginNameCamelCase(),
            ],
            $this->getStub($type)
        );

        $outputPath = plugin_path($this->getPluginUnderscoreCase()) . '/view/' .$name. '.blade.php';

        file_put_contents($outputPath, $viewTemplate);

        $this->output->writeln('File generated : ' . $outputPath);
    }

    /**
     * Generate CSS file
     *
     * @param $type
     * @param $name
     */
    protected function generateStyle($type, $name){

        $cssTemplate = str_replace(
            [
                '{{PluginName}}',
            ],
            [
                $this->getPluginNameCamelCase(),
            ],
            $this->getStub($type)
        );

        $outputPath = plugin_path($this->getPluginUnderscoreCase()) . '/assets/css/' .$name. '.css';

        file_put_contents($outputPath, $cssTemplate);

        $this->output->writeln('File generated : ' . $outputPath);
    }
}
