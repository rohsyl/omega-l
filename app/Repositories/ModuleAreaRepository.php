<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 18.09.18
 * Time: 12:59
 */

namespace Omega\Repositories;


use Illuminate\Support\Facades\DB;
use Omega\Models\ModuleArea;

class ModuleAreaRepository
{
    private $moduleArea;

    public function __construct(ModuleArea $moduleArea) {
        $this->moduleArea = $moduleArea;
    }

    public function getByNameAndThemeName($areaName, $themeName){
        return $this->moduleArea->where('name', $areaName)->where('theme', $themeName)->first();
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


    public function getInsertablePlugins($pageId = null){
        $query = "SELECT p.* 
                    FROM modules AS m
                    INNER JOIN plugins AS p ON p.id = m.fkPlugin
                    WHERE m.isEnabled = 1";
        if(isset($pageId)){
            $query .= " AND (fkPage = ? OR fkPage IS NULL) ";
        }
        else{
            $query .= " AND fkPage IS NULL ";
        }
        $query .= " GROUP BY p.name ";

        $entities = DB::select($query, isset($pageId) ? [$pageId] : []);
        return $entities;
    }

    public function getAllModuleByPluginAndPage($pluginId, $pageId = null){
        $query = "SELECT  *
                    FROM modules
                    WHERE fkPlugin = ?
                    AND isComponent = 0";
        if(isset($pageId))
            $query .= " AND (fkPage = ? OR fkPage IS NULL)";
        else
            $query .= " AND fkPage IS NULL";

        $modules = DB::select($query, isset($pageId) ? [$pluginId, $pageId] : [$pluginId]);
        return $modules;
    }

}