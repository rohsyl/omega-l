<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 22.05.2018
 * Time: 19:46
 */

namespace Omega\Plugin\Dataentity\Library\DAL;

use Omega\Library\Util\Util;
use PDO;
use Omega\Library\DAL\Db;
use Omega\Plugin\Dataentity\Library\DTO\DataEntityView;

class DataEntityViewDb extends Db
{
    public static function GetAllViewsForEntity($idEntity){
        return parent::GetManyWhere(new DataEntityView(), $idEntity, 'fkForm');
    }

    public static function GetView($id){
        return parent::GetOne(new DataEntityView(), $id);
    }

    public static function GetViewByName($name){
        return parent::GetOneWhere(new DataEntityView(), $name, 'name', true);
    }

    public static function GetViewOrFirstForEntity($id = null, $idEntity = null){

        if(isset($id)){
            return self::GetView($id);
        }

        if(isset($idEntity)){
            $entity = new DataEntityView();
            $className = get_class($entity);
            $tableName = $entity->getTableName();
            $dbh = self::GetPDO();
            $stmt = $dbh->prepare(sprintf("SELECT * FROM %s WHERE fkForm = :fkForm LIMIT 0, 1", $tableName));
            $stmt->bindParam(':fkForm', $idEntity);
            $stmt->execute();
            $view = $stmt->fetch(PDO::FETCH_ASSOC);
            if($view !== false){
                return parent::FillEntity($view, $className);
            }
        }
        return null;
    }

    public static function Insert($entity) {
        return parent::Insert($entity);
    }

    public static function Update($entity) {
        return parent::Update($entity);
    }

    public static function DeleteAllForEntity($idEntity){
        return parent::DeleteWhere(new DataEntityView(), $idEntity, 'fkForm');
    }

    public static function Delete($id) {
        return parent::DeleteWhere(new DataEntityView(), $id);
    }
}