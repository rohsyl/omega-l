<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 14.03.2018
 * Time: 17:33
 */

namespace Omega\Plugin\Portfolio\Library\DAL;

use Omega\Library\DAL\Db;
use Omega\Plugin\Portfolio\Library\DTO\PortfolioSliderItem;

class PortfolioSliderItemDb extends Db
{
    public static function GetAllSliderItems($idPortfolioItem){
        return parent::GetManyWhere(new PortfolioSliderItem(), $idPortfolioItem, 'fkPortfolioItem');
    }

    public static function AddSliderItem($idItem){
        $si = new PortfolioSliderItem();
        $si->fkPortfolioItem = $idItem;
        return parent::Insert($si);
    }

    public static function SaveSliderItem($entity) {
        return parent::Update($entity);
    }

    public static function Delete($id){
        return parent::DeleteWhere(new PortfolioSliderItem(), $id);
    }

    public static function DeleteAllSliderItem($idPortfolioItem){
        return parent::DeleteWhere(new PortfolioSliderItem(), $idPortfolioItem, 'fkPortfolioItem');
    }

}