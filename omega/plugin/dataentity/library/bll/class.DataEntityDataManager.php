<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 29.05.2018
 * Time: 13:21
 */

namespace Omega\Plugin\Dataentity\Library\BLL;


use Omega\Library\BLL\Manager;
use Omega\Plugin\Dataentity\Library\DAL\DataEntityDataDb;
use Omega\Plugin\Dataentity\Library\DTO\DataEntityData;

class DataEntityDataManager extends Manager
{
    /**
     * Get a dataentitydata by id
     * @param $id int The given id
     * @return DataEntityData|null
     */
    public static function GetData($id){
        return DataEntityDataDb::GetData($id);
    }

    /**
     * Get all dataentitydata for the given entity
     * @param $fkEntity int The id of the entity
     * @return DataEntityData[]
     */
    public static function GetAllDatas($fkEntity){
        return DataEntityDataDb::GetAllDatas($fkEntity);
    }

    /**
     * Insert or update the entity
     * @param $entity DataEntityData
     * @return bool True if success
     */
    public static function Save($entity)
    {
        if($entity->id == null){
            return DataEntityDataDb::Insert($entity);
        }
        else{
            return DataEntityDataDb::Update($entity);
        }
    }

    /**
     * Delete all data for the given entity
     * @param $idEntity int The id of the entity
     * @return bool True if success
     */
    public static function DeleteAllForEntity($idEntity){
        return DataEntityDataDb::DeleteAllForEntity($idEntity);
    }

    /**
     * Delete by id
     * @param $id int The id
     * @return bool True if success
     */
    public static function Delete($id) {
        return DataEntityDataDb::Delete($id);
    }
}