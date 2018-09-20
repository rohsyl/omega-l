<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 14.03.2018
 * Time: 17:33
 */

namespace Omega\Plugin\Portfolio\Library\DAL;

use Omega\Library\DAL\Db;
use Omega\Plugin\Portfolio\Library\DTO\PortfolioItem;

class PortfolioItemDb extends Db
{
    public static function GetAllItems(){
        return parent::GetAll(new PortfolioItem());
    }

    public static function GetItem($id){
        return parent::GetOne(new PortfolioItem(), $id);
    }

    public static function Insert($entity) {
        return parent::Insert($entity);
    }

    public static function Update($entity) {
        return parent::Update($entity);
    }

    public static function Delete($id){
        return parent::DeleteWhere(new PortfolioItem(), $id);
    }
}