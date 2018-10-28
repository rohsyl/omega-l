<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 19.09.18
 * Time: 12:56
 */

namespace Omega\Repositories;

use Omega\Models\Plugin;
use Omega\Utils\Plugin\PluginMeta;
use Omega\Utils\Plugin\Type;

class PluginRepository
{
    private $plugin;

    public function __construct(Plugin $plugin){
        $this->plugin = $plugin;
    }

    public function get($id){
        return $this->plugin->find($id);
    }

    public function getByName($name){
        return $this->plugin->where('name', $name)->first();
    }

    public function create($name){
        $plugin = $this->getByName($name);
        if(isset($plugin))
            return $plugin;

        $plugin = new $this->plugin();
        $plugin->name = $name;
        $plugin->isEnabled = true;
        $plugin->save();
        return $plugin;
    }

    public function enable($id){
        $plugin = $this->get($id);
        $plugin->isEnable = true;
        return $plugin->save();
    }

    public function disable($id){
        $plugin = $this->get($id);
        $plugin->isEnable = false;
        return $plugin->save();
    }

    public function destroy($name){
        return $this->plugin->where('name', $name)->delete();
    }

    public function getInstalledPlugin(){
        return $this->plugin->all();
    }

    public function getPluginInMenu(){
        $plugins = $this->getInstalledPlugin();
        $menuPlugins = [];
        foreach($plugins as $plugin){
            $meta = new PluginMeta($plugin->name);
            if($meta->getOption('displayInMenu') == 1){
                $menuPlugins[] = $plugin;
            }
        }
        return $menuPlugins;
    }

    public function getUnstalledPlugins(){
        $pluginPath = plugin_path();
        $dir = opendir ($pluginPath);
        $folders = array();
        while($element = readdir($dir)) {
            if($element != '.' && $element != '..' && 0 !== strpos($element, '__')) {
                if (is_dir($pluginPath . DS . $element) && file_exists($pluginPath . DS . $element . '/plugin.json')) {
                    $name = $element;
                    if($this->getByName($name) == null)
                        $folders[] = $element;
                }
            }
        }
        return $folders;
    }

    public function getPluginsWithModulesSupport(){
        $plugins = $this->getInstalledPlugin();
        $modules = array();
        foreach($plugins as $plugin) {
            if(Type::FormExistsForModule($plugin->id)){
                $modules[] = $plugin;
            }
        }
        return $modules;
    }

    public function getPluginsWithComponentsSupport(){
        $plugins = $this->getInstalledPlugin();
        $modules = array();
        foreach($plugins as $plugin) {
            if(Type::FormExistsForComponent($plugin->id)){
                $modules[] = $plugin;
            }
        }
        return $modules;
    }
}