<?php

namespace Omega\Http\Controllers;

use Omega\Repositories\PluginRepository;
use Omega\Utils\Plugin\Plugin as PluginUtils;

class PluginController extends Controller
{
    private $pluginRepository;

    private $protectedAction = ['install', 'uninstall'];

    public function __construct(PluginRepository $pluginRepository){
        $this->pluginRepository = $pluginRepository;
    }

    //
    public function index(){
        return view('plugin.index')->with([
            'installed' => to_meta($this->pluginRepository->getInstalledPlugin()),
            'uninstalled' => to_meta($this->pluginRepository->getUnstalledPlugins()),
        ]);
    }

    public function install($name){
        $this->pluginRepository->create($name);

        PluginUtils::Call($name, 'install');

        toast()->success('Plugin ' . $name . ' installed succesfully.');
        return redirect()->route('admin.plugins');
    }

    public function uninstall($name){

        $this->pluginRepository->destroy($name);

        PluginUtils::Call($name, 'install');

        toast()->success('Plugin ' . $name . ' uninstalled succesfully.');
        return redirect()->route('admin.plugins');
    }


    public function run($name, $action){
        if(in_array($action, $this->protectedAction)){
            toast()->error('This action can\'t be called directly...');
            return redirect()->route('admin.plugins');
        }
        return PluginUtils::Call($name, $action);
    }
}
