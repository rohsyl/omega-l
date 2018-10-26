<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 18.09.18
 * Time: 15:53
 */

namespace Omega\Repositories;


use Illuminate\Support\Facades\DB;
use Omega\Models\Module;

class ModuleRepository
{
    private $module;

    public function __construct(Module $module) {
        $this->module = $module;
    }

    public function create($fkPlugin, $name, $param = [], $isComponent = false, $isEnabled = true, $fkPage = null){
        $module = new Module();
        $module->name = $name;
        $module->fkPlugin = $fkPlugin;
        $module->fkPage = $fkPage;
        $module->isEnabled = $isEnabled;
        $module->param = json_encode($param);
        $module->order = 0;
        $module->isComponent = $isComponent;
        $module->save();
        return $module;
    }

    public function saveParam($module, $param){
        $module->param = json_encode($param);
        $module->save();
        return $module;
    }

    public function destroyByName($name){
        return $this->module->where('name', $name)->delete();
    }

    public function delete($id){
        return $this->module->destroy($id);
    }

    public function get($id){
        return $this->module->find($id);
    }

    public function getByName($name){
        return $this->module->where('name', $name)->first();
    }

    public function getAllComponentsByPage($pageId){
        return $this->module->with('position')->where('fkPage', $pageId)->where('isComponent', 1)->get();
    }

    public function getAllModulesByPage($pageId){
        return $this->module->where('fkPage', $pageId)->where('isComponent', 0)->get();
    }
}