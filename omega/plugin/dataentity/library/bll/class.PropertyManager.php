<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 16.05.2018
 * Time: 09:43
 */

namespace Omega\Plugin\Dataentity\Library\BLL;


use Omega\Library\BLL\Manager;
use Omega\Plugin\Dataentity\Library\DAL\PropertyDb;
use Omega\Plugin\Dataentity\Library\DTO\Property;

class PropertyManager extends Manager
{
    /**
     * Get all properties for a given entity
     * @param $idEntity int The id of the entity
     * @return Property[]|null An array of property
     */
    public static function GetAllPropertiesOfEntity($idEntity){
        return PropertyDb::GetAllPropertiesOfEntity($idEntity);
    }

    /**
     * Get all heading properties for a given entity
     * @param $idEntity int The id of the entity
     * @return Property[]|null An array of property
     */
    public static function GetAllHeadingPropertiesOfEntity($idEntity){
        return PropertyDb::GetAllHeadingPropertiesOfEntity($idEntity);
    }

    /**
     * Get a property by id
     * @param $idProperty int The id of the property
     * @return Property|null The property or null
     */
    public static function GetProperty($idProperty){
        return PropertyDb::GetProperty($idProperty);
    }

    /**
     * Insert or Update a propoerty
     * @param $entity Property The porperty
     * @return bool True if success
     */
    public static function Save($entity) {
        if($entity->id == null){
            return PropertyDb::Insert($entity);
        }
        else{
            return PropertyDb::Update($entity);
        }
    }

    /**
     * Delete a property by id
     * @param $id int The id of the property
     * @return bool True if success
     */
    public static function Delete($id) {
        return PropertyDb::Delete($id);
    }
}