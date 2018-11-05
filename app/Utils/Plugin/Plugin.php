<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 19.09.18
 * Time: 15:06
 */

namespace Omega\Utils\Plugin;


class Plugin
{
    /**
     * @param $name
     * @param $action
     * @return bool
     */
    public static function Call($name, $action){

        $className = BController::getClassName($name);

        if(!class_exists($className)){
            return false;
        }

        $pluginController = new $className();

        if(!method_exists($pluginController, $action)){
            return false;
        }

        return $pluginController->$action();
    }

    /**
     * @param string $name The name of the plugin
     * @return false|FController The front-end controller of the plugin
     */
    public static function FInstance($name){
        $className = FController::getClassName($name);

        if(!class_exists($className)){
            return false;
        }

        $pluginController = new $className();

        return $pluginController;
    }

}