<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 22.05.2018
 * Time: 19:46
 */

namespace Omega\Plugin\Dataentity\Library\DAL;

use Omega\Library\Util\Util;
use Omega\Plugin\Dataentity\Library\DTO\DataEntityLayout;
use PDO;
use Omega\Library\DAL\Db;
use Omega\Plugin\Dataentity\Library\DTO\DataEntityView;

class DataEntityLayoutDb extends Db
{
    public static function GetAllLayouts(){
        return parent::GetAll(new DataEntityLayout());
    }

    public static function GetLayout($id){
        return parent::GetOne(new DataEntityLayout(), $id);
    }


    public static function Insert($entity) {
        return parent::Insert($entity);
    }

    public static function Update($entity) {
        return parent::Update($entity);
    }

    public static function Delete($id) {
        return parent::DeleteWhere(new DataEntityLayout(), $id);
    }
}