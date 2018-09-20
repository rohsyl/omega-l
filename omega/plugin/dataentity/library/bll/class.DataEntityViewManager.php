<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 22.05.2018
 * Time: 19:46
 */

namespace Omega\Plugin\Dataentity\Library\BLL;


use Omega\Library\BLL\Manager;
use Omega\Plugin\Dataentity\Library\DAL\DataEntityViewDb;
use Omega\Plugin\Dataentity\Library\DTO\DataEntityView;

class DataEntityViewManager extends Manager
{
    /**
     * Get all views for the given entity id
     * @param $idEntity int The id of the entity
     * @return DataEntityView[]|null
     */
    public static function GetAllViewsForEntity($idEntity){
        return DataEntityViewDb::GetAllViewsForEntity($idEntity);
    }

    /**
     * Get a view by id
     * @param $id int The id of the view
     * @return DataEntityView|null The view
     */
    public static function GetView($id){
        return DataEntityViewDb::GetView($id);
    }

    /**
     * Get a view by name
     * @param $name string The name of the view
     * @return DataEntityView|null The view
     */
    public static function GetViewByName($name){
        return DataEntityViewDb::GetViewByName($name);
    }
    /**
     * Get a view by id or fist view of entity
     * @param $id int The id of the view
     * @param $idEntity int The id of the entity
     * @return DataEntityView|null The view
     */
    public static function GetViewOrFirstForEntity($id = null, $idEntity = null){
        return DataEntityViewDb::GetViewOrFirstForEntity($id, $idEntity);
    }

    /**
     * Insert or update a dataentityview
     * @param $entity DataEntityView The entity
     * @return bool True if success
     */
    public static function Save($entity) {
        if($entity->id == null){
            return DataEntityViewDb::Insert($entity);
        }
        else {
            return DataEntityViewDb::Update($entity);
        }
    }

    /**
     * Delete all view for the given entity
     * @param $idEntity int The id of the entity
     * @return bool True if success
     */
    public static function DeleteAllForEntity($idEntity){
        return DataEntityViewDb::DeleteAllForEntity($idEntity);
    }

    /**
     * Delete the view by id
     * @param $id int The id
     * @return bool True if success
     */
    public static function Delete($id) {
        return DataEntityViewDb::Delete($id);
    }
}