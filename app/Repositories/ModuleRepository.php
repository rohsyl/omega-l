<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 18.09.18
 * Time: 15:53
 */

namespace Omega\Repositories;


use Omega\Module;

class ModuleRepository
{
    private $module;

    public function __construct(Module $module) {
        $this->module = $module;
    }

    public function getAllComponentsByPage($pageId){
        return $this->module->with('position')->where('position.fkPage', $pageId)->where('isComponent', 1)->get();
    }

    public function getAllModulesByPage($pageId){
        return $this->module->with('position')->where('position.fkPage', $pageId)->where('isComponent', 0)->get();
    }
}