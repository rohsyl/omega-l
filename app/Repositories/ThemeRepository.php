<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 18.09.18
 * Time: 13:10
 */

namespace Omega\Repositories;


use Omega\Theme;

class ThemeRepository
{
    private $theme;

    public function __construct(Theme $theme) {
        $this->theme = $theme;
    }

    public function getCurrentThemeName(){
        return om_config('om_theme_name');
    }

    public function getThemeByName($name){
        return $this->theme->where('name', $name)->first();
    }

    public function getCurrentTheme(){
        return $this->getThemeByName($this->getCurrentThemeName());
    }
}