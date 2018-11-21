<?php

namespace Omega\Http\Controllers;

use Omega\Repositories\PluginRepository;
use Omega\Utils\Plugin\Plugin as PluginUtils;
use Omega\Utils\Plugin\PluginMeta;

class PluginController extends AdminController
{
    private $pluginRepository;

    /**
     * Register here all action that can be called with the run method
     * @var array
     */
    private $protectedAction = ['install', 'uninstall'];

    public function __construct(PluginRepository $pluginRepository){
        parent::__construct();
        $this->pluginRepository = $pluginRepository;
    }

    public function index(){
        return view('plugin.index')->with([
            'installed' => to_meta($this->pluginRepository->getInstalledPlugin()),
            'uninstalled' => to_meta($this->pluginRepository->getUnstalledPlugins()),
        ]);
    }

    public function install($name, $confirm = false){
        if($confirm)
        {
            $this->pluginRepository->create($name);

            $result = PluginUtils::Call($name, 'install');

            if(!$result){
                $this->pluginRepository->destroy($name);
                toast()->error(__('Action not found (Do an "composer dumpautoload")'));
                return redirect()->route('admin.plugins');
            }

            // publish plugin assets
            $publishResult = PluginUtils::Publish($name);

            if($publishResult['code'] === 0){
                toast()->success(__('Plugin installed succesfully.') . ' ' . camelize_plugin($name));
                toast()->success(__('Plugin publised!'));
            }
            else {
                toast()->error(__('Error') . '<br />' . $publishResult['output']);
            }

            return redirect()->route('admin.plugins'); }
        else {
            return view('plugin.confirm')->with([
                'message' => __('Do you really want to install this plugin ?') ,
                'routeYes' => route('admin.plugins.install', ['name' => $name, 'confirm' => 1]),
                'routeNo' => route('admin.plugins'),
            ]);
        }
    }

    public function uninstall($name, $confirm = false){

        if($confirm)
        {
            PluginUtils::Call($name, 'uninstall');

            $this->pluginRepository->destroy($name);

            toast()->success(__('Plugin uninstalled succesfully.') . ' ' . camelize_plugin($name));
            return redirect()->route('admin.plugins');
        }
        else {
            return view('plugin.confirm')->with([
                'message' => __('Do you really want to uninstall this plugin ?') ,
                'routeYes' => route('admin.plugins.uninstall', ['name' => $name, 'confirm' => 1]),
                'routeNo' => route('admin.plugins'),
            ]);
        }
    }


    public function run($name, $action){
        if(in_array($action, $this->protectedAction)){
            toast()->error(__('This action can\'t be called directly...'));
            return redirect()->route('admin.plugins');
        }
        $response = PluginUtils::Call($name, $action);

        if(!$response){
            toast()->error(__('Action not found (Do an "composer dumpautoload")'));
            return redirect()->route('admin.plugins');
        }

        return $response;
    }

    public function settings($name){
        return view('plugin.meta')->with([
            'meta' => new PluginMeta($name),
        ]);
    }

    public function publish($name){
        $publishResult = PluginUtils::Publish($name);

        if($publishResult['code'] === 0){
            toast()->success(__('Plugin publised!'));
        }
        else {
            toast()->error(__('Error') . '<br />' . $publishResult['output']);
        }
        return redirect()->route('admin.plugins.settings', ['name' => $name]);
    }
}
