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


if(!function_exists('get_template_register')) {

    function get_template_register($themeName)
    {
        $registerPath = Path::Combine(theme_path(), $themeName, 'template', 'register.php');

        if(!file_exists($registerPath)){
            return null;
        }

        return include($registerPath);
    }
}


if(!function_exists('theme_encode_components_template')) {
    /**
     * @param $themeName string
     * @param $newView \Omega\Utils\Theme\ComponentView
     * @return string
     */
    function theme_encode_components_template($themeName, $newView)
    {
        return $themeName . '.' . $newView->getPluginName() . '.' . $newView->getViewName() . '.' . $newView->getNewViewPath();
    }
}

if(!function_exists('theme_decode_components_template')) {
    /**
     * @param $componentsTemplateString string
     * @return \Omega\Utils\Theme\ComponentView
     */
    function theme_decode_components_template($componentsTemplateString)
    {
        $t = explode('.',  $componentsTemplateString);
        $themeName = $t[0];
        $pluginName = $t[1];
        $viewName = $t[2];
        $newViewPath = $t[3];

        $register = get_template_register($themeName);

        $cv = $register->getComponentView($pluginName, $viewName, $newViewPath);
        $cv->setThemeName($themeName);

        return $cv;
    }
}