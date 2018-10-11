<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 18.09.18
 * Time: 12:59
 */

namespace Omega\Repositories;


use Omega\ModuleArea;

class ModuleAreaRepository
{
    private $moduleArea;

    public function __construct(ModuleArea $moduleArea) {
        $this->moduleArea = $moduleArea;
    }

    public function getAllModuleAreaByThemeName($themeName){
        return $this->moduleArea->where('theme', $themeName)->get();
    }

    public function exists($areaName, $themeName){
        return $this->moduleArea->where('name', $areaName)->where('theme', $themeName)->exists();
    }

    public function create($areaName, $themeName){
        $ma = new ModuleArea();
        $ma->name = $areaName;
        $ma->theme = $themeName;
        $ma->save();
        return $ma;
    }

    public function deleteByName($areaName, $themeName){
        return $this->moduleArea->where('name', $areaName)->where('theme', $themeName)->delete();
    }

    public function deleteByTheme($themeName){
        return $this->moduleArea->where('theme', $themeName)->delete();
    }
}