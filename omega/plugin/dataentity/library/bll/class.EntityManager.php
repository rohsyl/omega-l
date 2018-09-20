<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 16.05.2018
 * Time: 09:32
 */

namespace Omega\Plugin\Dataentity\Library\BLL;


use Omega\Library\BLL\Manager;
use Omega\Plugin\Dataentity\Library\DAL\EntityDb;
use Omega\Plugin\Dataentity\Library\DataentityUtil;
use Omega\Plugin\Dataentity\Library\DTO\Entity;

class EntityManager extends Manager
{
    /**
     * Get all entity
     * @return Entity[] The list of entity
     */
    public static function GetAllEntites(){
        return EntityDb::GetAllEntites();
    }

    /**
     * Get an entity by id
     * @param $id int The id of the entity
     * @return Entity|null The entity or null
     */
    public static function GetEntity($id){
        return EntityDb::GetEntity($id);
    }

    /**
     * Get an entity by name
     * @param $name int The id of the entity
     * @return Entity|null The entity or null
     */
    public static function GetEntityByName($name){
        return EntityDb::GetEntityByName($name);
    }


    /**
     * Insert or update an Entity
     * @param $entity Entity
     * @return bool True if success
     */
    public static function Save($entity) {
        $entity->fkPlugin = DataentityUtil::GetPluginId();
        $entity->isComponent = false;
        $entity->isModule = false;
        if($entity->id == null){
            return EntityDb::Insert($entity);
        }
        else{
            return EntityDb::Update($entity);
        }
    }

    /**
     * Delete an entity by id
     * @param $id int The id of the entity
     * @return bool True if success
     */
    public static function Delete($id) {
        return EntityDb::Delete($id);
    }
}