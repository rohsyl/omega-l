<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 16.05.2018
 * Time: 09:40
 */

namespace Omega\Plugin\Dataentity\Library\DAL;


use Omega\Library\DAL\Db;
use Omega\Plugin\Dataentity\Library\DTO\Property;

class PropertyDb extends Db
{
    public static function GetAllPropertiesOfEntity($idEntity){
        return parent::GetManyWhereOrdered(new Property(), $idEntity, 'fkForm', 'order');
    }

    public static function GetAllHeadingPropertiesOfEntity($idEntity){
        $entity = new Property();
        $className = get_class($entity);
        $tableName = $entity->getTableName();
        $dbh = self::GetPDO();
        $stmt = $dbh->prepare(sprintf("SELECT * FROM %s WHERE fkForm = :fkForm AND heading = 1 ORDER BY `order` ASC", $tableName));
        $stmt->bindParam(':fkForm', $idEntity);
        $stmt->execute();
        return parent::FillEntityArray($stmt, $className);
    }

    public static function GetProperty($idProperty){
        return parent::GetOne(new Property(), $idProperty);
    }

    public static function Insert($entity) {
        return parent::Insert($entity);
    }

    public static function Update($entity) {
        return parent::Update($entity);
    }

    public static function Delete($id) {
        return parent::DeleteWhere(new Property(), $id);
    }
}