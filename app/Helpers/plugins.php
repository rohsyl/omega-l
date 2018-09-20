<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 19.09.18
 * Time: 13:42
 */

if(!function_exists('plugin_path')){
    /**
     * @return string
     */
    function plugin_path(){
        return base_path('omega/plugin');
    }
}

if(!function_exists('to_meta')){

    /**
     * Convert a Plugin/string or an array of Plugin/string to PluginMeta
     * @param $plugins \Omega\Plugin|array|string
     * @return array|\Omega\Utils\Plugin\PluginMeta
     */
    function to_meta($plugins){
        if(is_array($plugins) || $plugins instanceof \Illuminate\Database\Eloquent\Collection){
            $metas = [];
            foreach($plugins as $plugin){
                if($plugin instanceof \Omega\Plugin)
                    $metas[] = new \Omega\Utils\Plugin\PluginMeta($plugin->name);
                else
                    $metas[] = new \Omega\Utils\Plugin\PluginMeta($plugin);
            }
            return $metas;
        }
        else if($plugins instanceof \Omega\Plugin){
            return new \Omega\Utils\Plugin\PluginMeta($plugins->name);
        }
        else if(is_string($plugins)){
            return new \Omega\Utils\Plugin\PluginMeta($plugins);
        }
    }
}

if(!function_exists('route_plugin')){
    /**
     * @param $name
     * @param $action
     * @return string
     */
    function route_plugin($name, $action, $param = []){
        return route('admin.plugins.run', array_merge(['name' => $name, 'action' => $action], $param));
    }
}