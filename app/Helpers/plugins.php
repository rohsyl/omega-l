<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 19.09.18
 * Time: 13:42
 */
use Omega\Models\Plugin;
use Illuminate\Database\Eloquent\Collection;
use Omega\Utils\Plugin\PluginMeta;
use Omega\Repositories\PluginRepository;

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
        if(is_array($plugins) || $plugins instanceof Collection){
            $metas = [];
            foreach($plugins as $plugin){
                if($plugin instanceof Plugin)
                    $metas[] = new PluginMeta($plugin->name);
                else
                    $metas[] = new PluginMeta($plugin);
            }
            return $metas;
        }
        else if($plugins instanceof Plugin){
            return new PluginMeta($plugins->name);
        }
        else if(is_string($plugins)){
            return new PluginMeta($plugins);
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


if(!function_exists('camelize_plugin')){
    /**
     * @param $input
     * @param string $separator
     * @return mixed
     */
    function camelize_plugin($input, $separator = '_')
    {
        return str_replace($separator, '', ucwords($input, $separator));
    }
}

if(!function_exists('add_sub_actions_plugin')){
    function add_sub_actions_plugin(){
        $pluginRepository = new PluginRepository(new Plugin());
        $plugins = $pluginRepository->getPluginInMenu();
        $actions = [];
        $actions[] = add_action(route('admin.plugins'), 'glyphicon glyphicon-list-alt', __('Manage plugins'));
        foreach($plugins as $plugin){
            $meta = new PluginMeta($plugin->name);
            $actions[] = add_action(route_plugin($plugin->name, 'index'), 'fa fa-cube', $meta->getTitle());
        }
        return $actions;
    }
}