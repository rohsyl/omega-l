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

    /**
     * @param $areaName
     * @param $themeName
     * @return ModuleArea
     */
    public function getByNameAndThemeName($areaName, $themeName){
        return $this->moduleArea->where('name', $areaName)->where('theme', $themeName)->first();
    }


    /**
     * @param $areaName
     * @param $themeName
     * @return ModuleArea
     */
    public function getByNameAndThemeNameWithRel($areaName, $themeName){
        return $this->moduleArea
            ->with('positions.module.plugin')
            ->where('name', $areaName)
            ->where('theme', $themeName)
            ->first();
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

    public function getContentOnPage($pageId, $name, $theme){

        $dbh = self::GetPDO();
        $stmt = $dbh->prepare("SELECT plugName, moduleParam, fkPlugin, om_module.id AS moduleId 
                            FROM om_module_area 
                            INNER JOIN om_position ON om_module_area.id = om_position.fkModuleArea
                            INNER JOIN om_module ON om_module.id = om_position.fkModule
                            INNER JOIN om_plugin ON om_plugin.id = om_module.fkPlugin
                            WHERE om_module_area.areaName LIKE :areaName 
                              AND om_module_area.areaTheme LIKE :areaTheme 
                              AND (
                                  om_position.fkPage = :fkPage
                                  OR om_position.fkPage = 0)
                            ORDER BY positionOrder ASC");
        $stmt->bindParam(':areaName', $name);
        $stmt->bindParam(':areaTheme', $theme);
        $stmt->bindParam(':fkPage', $pageId);
        $stmt->execute();

        $elements = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $entity = new ModuleAreaContentResult();
            EntityFiller::Fill($entity, $row);
            $elements[] = $entity;
        }
        return $elements;
    }
}