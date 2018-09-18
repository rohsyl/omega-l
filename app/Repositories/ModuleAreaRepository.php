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
}