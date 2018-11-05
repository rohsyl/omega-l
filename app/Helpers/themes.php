<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 02.10.18
 * Time: 11:46
 */
use Omega\Utils\Path;
use Omega\Utils\Url;

if(!function_exists('theme_path')){
    /**
     * @return string
     */
    function theme_path($name = null){
        $path = base_path('omega/theme');
        if(isset($name)){
            return Path::Combine($path, $name);
        }
        return $path;
    }
}


if(!function_exists('theme_css_path')){
    /**
     * @return string
     */
    function theme_css_path($name){
        $path = base_path('omega/theme');

        return Path::Combine($path, $name, 'assets', 'css', 'theme');
    }
}


if(!function_exists('theme_asset')) {
    /**
     * @return string
     */
    function theme_asset($path)
    {
        return asset('theme/'.$path);
    }
}

if(!function_exists('theme_asset_csstheme')) {
    /**
     * @return string
     */
    function theme_asset_csstheme($filename)
    {
        return asset(Url::Combine('theme', 'css', 'theme', $filename));
    }
}