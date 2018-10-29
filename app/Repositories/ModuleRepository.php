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

    public function createComponent($pageId, $plugin) {
        $maxOrder = $this->getMaxOrderOnPage($pageId);
        $maxId = $this->getMaxId();

        $m = new Module();
        $m->fkPlugin = $plugin->id;
        $m->fkPage = $pageId;
        $m->name = $plugin->name.$maxId;
        $m->param = json_encode(array(
            'settings' => array('compId' => $plugin->name.$maxId)
        ));
        $m->isEnabled = true;
        $m->isComponent = true;
        $m->order = $maxOrder + 1;

        $m->save();

        return $m;
    }

    private function getMaxOrderOnPage($pageId){
        return $this->module->where('fkPage', $pageId)->max('order');
    }


    private function getMaxId(){
        return $this->module->max('id');
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
        return $this->module->where('fkPage', $pageId)->where('isComponent', 1)->orderBy('order')->get();
    }

    public function getAllModulesByPage($pageId){
        return $this->module->where('fkPage', $pageId)->where('isComponent', 0)->get();
    }


    public function componentOrderInitForPage($pageId){
        $components = $this->getAllComponentsByPage($pageId);
        $i = 1;
        foreach($components as $comp){
            $comp->order = $i;
            $comp->save();
            $i++;
        }
    }

    public function componentOrderSetOrderUpper($compId, $pageId){
        $module = $this->get($compId);
        $module->order = 1;
        $module->save();
        $components = $this->getAllComponentsByPage($pageId);
        $i = 2;
        foreach($components as $comp) {
            if($compId != $comp->id) {
                $comp->order = $i;
                $comp->save();
                $i++;
            }
        }
    }

    public function getModuleWithOrderAndPage($order, $pageId){

        return $this->module
            ->where('fkPage', $pageId)
            ->where('order', $order)
            ->first();
    }

    public function componentOrderSetOrderUp($compId, $pageId){
        $module = $this->get($compId);
        $order = $module->order;
        if($order > 0){
            $order = $order - 1;
            $moduleBefore = $this->getModuleWithOrderAndPage($order, $pageId);
            $moduleBefore->order = $order + 1;
            $moduleBefore->save();

            $module->order = $order;
            $module->save();
        }
    }

    public function ComponentOrderSetOrderDown($compId, $pageId){
        $maxOrder = $this->getMaxOrderOnPage($pageId);
        $module = $this->get($compId);
        $order = $module->order;
        if($order < $maxOrder){
            $order = $order + 1;
            $moduleAfter = $this->getModuleWithOrderAndPage($order, $pageId);
            $moduleAfter->order = $order - 1;
            $moduleAfter->save();

            $module->order = $order;
            $module->save();
        }
    }

    public function ComponentOrderSetOrderDowner($compId, $pageId){
        $maxOrder = $this->getMaxOrderOnPage($pageId);
        $module = $this->get($compId);
        $module->order = $maxOrder;
        $module->save();
        $components = $this->getAllComponentsByPage($pageId);
        $i = 1;
        foreach($components as $comp) {
            if($compId != $comp->id) {
                $comp->order = $i;
                $comp->save();
                $i++;
            }
        }
    }
}