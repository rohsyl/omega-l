<?php

namespace Omega\Http\Controllers;

use Illuminate\Http\Request;
use Omega\Repositories\PluginRepository;
use Omega\Utils\Plugin\Plugin as PluginUtils;

class PluginController extends Controller
{
    private $pluginRepository;

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
        $plugin = $this->pluginRepository->create($name);

        PluginUtils::Call($plugin->name, 'install');

        return redirect()->route('admin.plugins');
    }

    public function uninstall($name){

        $this->pluginRepository->destroy($name);

        PluginUtils::Call($name, 'install');

        return redirect()->route('admin.plugins');
    }


    public function run($name, $action){
        return PluginUtils::Call($name, $action);
    }
}
