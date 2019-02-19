<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 18.02.19
 * Time: 13:04
 */

namespace Omega\Utils\Theme;


use Omega\Utils\Path;

class ComponentView
{
    private $themeName;
    private $pluginName;
    private $viewName;
    private $versionString;
    private $newViewPath;
    private $label;


    public function __construct($pluginName, $viewName, $versionString, $newViewPath, $label){
        $this->pluginName = $pluginName;
        $this->viewName = $viewName;
        $this->versionString = $versionString;
        $this->newViewPath = $newViewPath;
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getPluginName()
    {
        return $this->pluginName;
    }

    /**
     * @return string
     */
    public function getViewName()
    {
        return $this->viewName;
    }

    /**
     * @return string
     */
    public function getVersionString()
    {
        return $this->versionString;
    }

    /**
     * @return string
     */
    public function getNewViewPath()
    {
        return $this->newViewPath;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $themeName
     */
    public function setThemeName($themeName): void
    {
        $this->themeName = $themeName;
    }

    /**
     * @return mixed
     */
    public function getThemeName()
    {
        return $this->themeName;
    }

    /**
     * Get the realpath to the componentstemplate view
     * @return string The realpath (absolute)
     */
    public function buildPath(){
        return Path::Combine(theme_path($this->getThemeName()), 'template', $this->getNewViewPath() . '.blade.php');
    }
}