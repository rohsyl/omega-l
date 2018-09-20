<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 14.03.2018
 * Time: 20:06
 */

namespace Omega\Plugin\Portfolio\Library\DAL;


use Omega\Library\DAL\Db;
use Omega\Plugin\Portfolio\Library\DTO\PortfolioCustomProperty;

class PortfolioCustomPropertyDb extends Db
{
    public static function GetAllCustonmProperties(){
        return parent::GetAllOrdered(new PortfolioCustomProperty(), 'propOrder', parent::ORDER_ASC);
    }

    public static function GetCustomProperty($id){
        return parent::GetOne(new PortfolioCustomProperty(), $id);
    }

    public static function Insert($entity) {
        return parent::Insert($entity);
    }

    public static function Update($entity) {
        return parent::Update($entity);
    }

    public static function Delete($id) {
        return parent::DeleteWhere(new PortfolioCustomProperty(), $id);
    }
}