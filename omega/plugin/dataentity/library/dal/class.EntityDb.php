<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 16.05.2018
 * Time: 08:28
 */

namespace Omega\Plugin\Dataentity\Library\DAL;


use Omega\Library\DAL\Db;
use Omega\Plugin\Dataentity\Library\DataentityUtil;
use Omega\Plugin\Dataentity\Library\DTO\Entity;

class EntityDb extends Db
{
    public static function GetAllEntites(){
        $pluginId = DataentityUtil::GetPluginId();
        $entity = new Entity();
        $className = get_class($entity);
        $tableName = $entity->getTableName();
        $dbh = self::GetPDO();
        $stmt = $dbh->prepare(sprintf("SELECT * FROM %s WHERE fkPlugin = :fkPlugin AND isModule = 0 AND isComponent = 0", $tableName));
        $stmt->bindParam(':fkPlugin', $pluginId);
        $stmt->execute();
        return parent::FillEntityArray($stmt, $className);
    }


    public static function GetEntity($id){
        return parent::GetOne(new Entity(), $id);
    }


    public static function GetEntityByName($name){
        return parent::GetOneWhere(new Entity(), $name, 'name', true);
    }

    public static function Update($entity) {
        return parent::Update($entity);
    }

    public static function Insert($entity) {
        return parent::Insert($entity);
    }

    public static function Delete($id) {
        return parent::DeleteWhere(new Entity(), $id);
    }
}