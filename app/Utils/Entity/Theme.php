<?php


namespace Omega\Utils\Entity;


use Omega\Utils\Path;

class Theme
{
    private $current;

    public function __construct()
    {
        $this->current = om_config('om_theme_name');
    }

    public function current() {
        return $this->current;
    }

    public function get($name = null) {
        return $this->theme->where('name', $name ?? $this->current)->first();
    }

    public function installer($name = null) {
        $themePath = theme_path($name ?? $this->current);
        $installationFile = Path::Combine($themePath, 'install', 'install.php');
        if (file_exists($installationFile))
            return (include $installationFile);
        return null;
    }

    public function installed($name = null) {
        return $this->theme->where('name', $name ?? $this->current)->exists();
    }

    public function installedThemes() {
        return Theme::all();
    }

    public function notInstalledThemes() {
        $themePath = theme_path();
        $dir = opendir ($themePath);
        $folders = array();
        while($element = readdir($dir)) {
            if($element != '.' && $element != '..' && 0 !== strpos($element, '__')) {
                if (is_dir($themePath . DS . $element)) {
                    $name = $element;
                    if(!$this->installed($name))
                        $folders[] = $element;
                }
            }
        }
        return $folders;
    }


    public  function templates($name = null)
    {
        $files = array();
        $themeFolder = theme_path($name ?? $this->current);
        $directory_path = Path::Combine($themeFolder, 'template');
        if(file_exists($directory_path)){
            $dir = opendir ($directory_path);
            while($element = readdir($dir))
            {
                if($element != '.' && $element != '..' && $element != 'register.php')
                {
                    if (!is_dir(Path::Combine($directory_path, $element)))
                        $files[] = without_ext(without_ext($element));
                }
            }
            sort($files);
        }
        return $files;
    }

    public function styles($name = null)
    {
        $directory_path = theme_css_path($name ?? $this->current);

        $file = array();
        if(file_exists($directory_path)){
            $dir = opendir ($directory_path);
            while($element = readdir($dir)) {
                if($element != '.' && $element != '..') {
                    if (!is_dir(Path::Combine($directory_path, $element))) {
                        $file[] = without_ext($element);
                    }
                }
            }
        }

        sort($file);
        return $file;
    }

    public function colors($name = null){
        $theme = $this->get($name ?? $this->current);
        $colors = array();
        if($theme != null){
            $colors = json_decode($theme->colors, false);
        }
        return $colors;
    }
}