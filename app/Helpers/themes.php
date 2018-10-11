<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 02.10.18
 * Time: 11:46
 */

if(!function_exists('theme_path')){
    /**
     * @return string
     */
    function theme_path($name = null){
        $path = base_path('omega/theme');
        if(isset($name)){
            return \Omega\Utils\Path::Combine($path, $name);
        }
        return $path;
    }
}