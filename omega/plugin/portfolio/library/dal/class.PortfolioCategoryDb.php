<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 14.03.2018
 * Time: 17:33
 */

namespace Omega\Plugin\Portfolio\Library\DAL;

use Omega\Library\DAL\Db;
use Omega\Plugin\Portfolio\Library\DTO\PortfolioCategory;

class PortfolioCategoryDb extends Db
{
    public static function GetAllCategories(){
        return parent::GetAll(new PortfolioCategory());
    }

    public static function GetCategory($id){
        return parent::GetOne(new PortfolioCategory(), $id);
    }

    public static function Insert($entity) {
        return parent::Insert($entity);
    }

    public static function Update($entity) {
        return parent::Update($entity);
    }

    public static function Delete($id){
        return parent::DeleteWhere(new PortfolioCategory(), $id);
    }
}