<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 18.09.18
 * Time: 13:10
 */

namespace Omega\Repositories;


use Omega\Models\Theme;
use Omega\Utils\Path;
use Omega\Utils\Theme\Installer;

class ThemeRepository
{
    private $theme;

    public function __construct(Theme $theme) {
        $this->theme = $theme;
    }

    public function getCurrentThemeName(){
        return om_config('om_theme_name');
    }

    public function setCurrentThemeName($name){
        return om_config(['om_theme_name' => $name]);
    }

    public function getThemeByName($name){
        return $this->theme->where('name', $name)->first();
    }

    public function getCurrentTheme(){
        return $this->getThemeByName($this->getCurrentThemeName());
    }

    public function getByName($name){
        return $this->theme->where('name', $name)->first();
    }

    public function create($name, $data){

        $theme = new Theme();
        $theme->name = $name;
        $theme->title = isset($data['title']) ? $data['title'] : $name;
        $theme->description = isset($data['description']) ? $data['description'] : '';
        $theme->website = isset($data['website']) ? $data['website'] : '';
        $theme->colors = json_encode(isset($data['colors']) ? $data['colors'] : []);
        $theme->save();
        return $theme;
    }

    public function delete($name){
        $this->theme->where('name', $name)->delete();
    }

    /**
     * @param $name The name of the theme
     * @return Installer The theme installer
     */
    public function getInstaller($name){
        $themePath = theme_path($name);

        $installationFile = Path::Combine($themePath, 'install', 'install.php');

        if (file_exists($installationFile))
            return (include $installationFile);

        return null;
    }

    public function isInstalled($name){
        return $this->getByName($name) != null;
    }

    public function getInstalledTheme(){
        return $this->theme->get();
    }

    public function getUninstalledTheme(){
        $themePath = theme_path();
        $dir = opendir ($themePath);
        $folders = array();
        while($element = readdir($dir)) {
            if($element != '.' && $element != '..' && 0 !== strpos($element, '__')) {
                if (is_dir($themePath . DS . $element)) {
                    $name = $element;
                    if($this->getByName($name) == null)
                        $folders[] = $element;
                }
            }
        }
        return $folders;
    }

    public  function getThemeTemplate($name)
    {
        $files = array();
        $themeFolder = theme_path($name);
        $directory_path = Path::Combine($themeFolder, 'template');
        if(file_exists($directory_path)){
            $dir = opendir ($directory_path);
            while($element = readdir($dir))
            {
                if($element != '.' && $element != '..')
                {
                    if (!is_dir(Path::Combine($directory_path, $element)))
                        $files[] = $element;
                }
            }
            sort($files);
        }
        return $files;
    }

    public function getThemeCssThemes($name)
    {
        $directory_path = theme_css_path($name);

        $file = array();
        if(file_exists($directory_path)){
            $dir = opendir ($directory_path);
            while($element = readdir($dir)) {
                if($element != '.' && $element != '..') {
                    if (!is_dir(Path::Combine($directory_path, $element))) {
                        $file[] = $element;
                    }
                }
            }
        }

        sort($file);
        return $file;
    }

    public function getThemeColors($name){
        $theme = $this->getByName($name);
        $colors = array();
        if($theme != null){
            $colors = json_decode($theme->colors, false);
        }
        return $colors;
    }
}