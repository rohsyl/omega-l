<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 29.05.2018
 * Time: 13:12
 */

namespace Omega\Plugin\Dataentity\Library\DAL;


use Omega\Library\DAL\Db;
use Omega\Plugin\Dataentity\Library\DTO\DataEntityData;

class DataEntityDataDb extends Db
{
    public static function GetData($id){
        return parent::GetOne(new DataEntityData(), $id);
    }

    public static function GetAllDatas($fkEntity){
        return parent::GetManyWhere(new DataEntityData(), $fkEntity, 'fkForm');
    }

    public static function Update($entity)
    {
        return parent::Update($entity);
    }

    public static function Insert($entity)
    {
        return parent::Insert($entity);
    }


    public static function DeleteAllForEntity($idEntity){
        return parent::DeleteWhere(new DataEntityData(), $idEntity, 'fkForm');
    }

    public static function Delete($id)
    {
        return parent::DeleteWhere(new DataEntityData(), $id);
    }
}