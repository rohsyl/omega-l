<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 04.10.18
 * Time: 09:13
 */

namespace Omega\Utils\Theme;

class Template
{
    private $name;
    private $componentsView = [];

    public static function For($name){
        return new Template($name);
    }

    public function __construct($name) {
        $this->name = $name;
    }

    /**
     * @param $pluginName string The name of the plugin
     * @param $viewName string The name of the view in the plugin view directory (the name without the extentions)
     * @param $versionString string The version of the plugin when this components template was created. It's used to keep track of plugin update and then to alert the developper.
     * @param $newViewPath string The path to the components template view. Relative path from the "template" directory in the theme directory. Without extention.
     * @return $this
     */
    public function registerComponentTemplateView($pluginName, $viewName, $versionString, $newViewPath, $label = null){
        $this->componentsView[$pluginName][$viewName][$newViewPath] = new ComponentView($pluginName, $viewName, $versionString, $newViewPath, $label);
        return $this;
    }

    /**
     * @return array
     */
    public function getAllComponentsView(): array
    {
        return $this->componentsView;
    }

    /**
     * @return array
     */
    public function getAllComponentsViewForPlugin($pluginName): array
    {
        return $this->componentsView[$pluginName];
    }

    public function getComponentView($pluginName, $viewName, $newViewPath){
        return $this->componentsView[$pluginName][$viewName][$newViewPath];
    }

}