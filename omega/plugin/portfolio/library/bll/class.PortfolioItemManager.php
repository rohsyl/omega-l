<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 14.03.2018
 * Time: 17:32
 */

namespace Omega\Plugin\Portfolio\Library\BLL;


use Omega\Library\BLL\Manager;
use Omega\Plugin\Portfolio\Library\DAL\PortfolioItemDb;
use Omega\Plugin\Portfolio\Library\DTO\PortfolioItem;

/**
 * This class allow you to manage PortfolioItem
 * @package Omega\Plugin\Portfolio\Library\BLL
 */
class PortfolioItemManager extends Manager
{
    /**
     * Get all PortfolioItem
     * @see PortfolioItem
     * @return PortfolioItem[]
     */
    public static function GetAllItems(){
        return PortfolioItemDb::GetAllItems();
    }

    /**
     * Get a PortfolioItem by id
     * @see PortfolioItem
     * @param $id int The id of the item
     * @return PortfolioItem|null
     */
    public static function GetItem($id){
        return PortfolioItemDb::GetItem($id);
    }

    /**
     * Insert or update a PortfolioItem
     * @see PortfolioItem
     * @param $entity PortfolioItem The item
     * @return bool True if success
     */
    public static function Save($entity) {
        if($entity->id == null)
            return PortfolioItemDb::Insert($entity);
        else
            return PortfolioItemDb::Update($entity);
    }

    /**
     * Delete a PortfolioItem by id
     * @see PortfolioItem
     * @param $id int The id of the tem
     * @return bool True if success
     */
    public static function Delete($id){
        return PortfolioItemDb::Delete($id);
    }
}