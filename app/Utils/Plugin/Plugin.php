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

}