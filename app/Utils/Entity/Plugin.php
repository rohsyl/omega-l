<?php


namespace Omega\Utils\Entity;


use Illuminate\Support\Collection;
use Omega\Utils\Plugin\PluginMeta;
use Omega\Utils\Plugin\Type;

class Plugin
{
    public function displayedInMenu() {
        return $this->installed()->filter(function($plugin) {
            $meta = new PluginMeta($plugin->name);
            return $meta->getOption('displayInMenu') == 1;
        });
    }

    /**
     * @return Collection
     */
    public function installed(){
        return \Omega\Models\Plugin::orderBy('name')->get();
    }

    public function notInstalled() {
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

    public function components(){
        return $this->installed()->filter(function($plugin) {
            return Type::FormExistsForComponent($plugin->id);
        });
    }

    public function modules() {
        return $this->installed()->filter(function($plugin) {
            return Type::FormExistsForModule($plugin->id);
        });
    }

    /**
     * @param $themeName
     * @param $pluginName
     * @return array
     */
    public function getPluginTemplateViewsByTheme($themeName, $pluginName){

        $register = get_template_register($themeName);

        if(!isset($register)) return [];

        return $register->getAllComponentsViewForPlugin($pluginName);
    }

    /**
     * @param $pluginTemplateString
     * @return mixed|null
     */
    public function isPluginTemplateUpToDate($pluginTemplateString){
        $cv = theme_decode_components_template($pluginTemplateString);

        if(!isset($cv)) return null;

        $pm = new PluginMeta($cv->getPluginName());
        return version_compare($pm->getVersion(), $cv->getVersionString(), "<=");
    }
}