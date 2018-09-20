<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 22.05.2018
 * Time: 08:37
 */

namespace Omega\Plugin\Dataentity\Library\BLL;


class PropertyTypeManager
{

    private static $types = array();

    public static function AddType($name, $classFullNamespace, $typeParam){
        self::$types[$name] = self::TypeToArray($name, $classFullNamespace, $typeParam);
    }

    public static function GetAllTypes(){
        return self::$types;
    }

    public static function GetType($name){
        return self::$types[$name];
    }


    private static function TypeToArray($name, $type, $param){
        return array(
            'name' => $name,
            'type' => $type,
            'param' => $param
        );
    }
}