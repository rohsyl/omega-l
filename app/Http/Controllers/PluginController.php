<?php

namespace Omega\Http\Controllers;

use Omega\Repositories\PluginRepository;
use Omega\Utils\Plugin\Plugin as PluginUtils;

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

    public function install($name){
        $this->pluginRepository->create($name);

        $result = PluginUtils::Call($name, 'install');

        if(!$result){
            $this->pluginRepository->destroy($name);
            toast()->error(__('Action not found (Do an "composer dumpautoload")'));
            return redirect()->route('admin.plugins');
        }

        toast()->success(__('Plugin installed succesfully.') . ' ' . camelize_plugin($name));
        return redirect()->route('admin.plugins');
    }

    public function uninstall($name){
        PluginUtils::Call($name, 'uninstall');

        $this->pluginRepository->destroy($name);

        toast()->success(__('Plugin uninstalled succesfully.') . ' ' . camelize_plugin($name));
        return redirect()->route('admin.plugins');
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
}
