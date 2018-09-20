<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 14.03.2018
 * Time: 17:32
 */

namespace Omega\Plugin\Portfolio\Library\BLL;

use Omega\Library\BLL\Manager;
use Omega\Plugin\Portfolio\Library\DAL\PortfolioCategoryDb;
use Omega\Plugin\Portfolio\Library\DTO\PortfolioCategory;

/**
 * This class allow you to manage PortfolioCategory
 * @package Omega\Plugin\Portfolio\Library\BLL
 */
class PortfolioCategoryManager extends Manager
{
    /**
     * Get all PortfolioCategory
     * @see PortfolioCategory
     * @return PortfolioCategory[]
     */
    public static function GetAllCategories(){
        return PortfolioCategoryDb::GetAllCategories();
    }

    /**
     * Get a PortfolioCategory by id
     * @see PortfolioCategory
     * @param $id int The id of the category
     * @return PortfolioCategory|null
     */
    public static function GetCategory($id){
        return PortfolioCategoryDb::GetCategory($id);
    }

    /**
     * Insert or update a PortfolioCategory
     * @see PortfolioCategory
     * @param $entity PortfolioCategory The category
     * @return bool True if success
     */
    public static function Save($entity) {
        if($entity->id == null)
            return PortfolioCategoryDb::Insert($entity);
        else
            return PortfolioCategoryDb::Update($entity);
    }

    /**
     * Delete a PortfolioCategory by id
     * @see PortfolioCategory
     * @param $id int The id of the category
     * @return bool True if success
     */
    public static function Delete($id){
        return PortfolioCategoryDb::Delete($id);
    }
}