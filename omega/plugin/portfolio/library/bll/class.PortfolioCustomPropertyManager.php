<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 15.03.2018
 * Time: 08:37
 */

namespace Omega\Plugin\Portfolio\Library\BLL;

use Omega\Library\BLL\Manager;
use Omega\Plugin\Portfolio\Library\DAL\PortfolioCustomPropertyDb;
use Omega\Plugin\Portfolio\Library\DTO\PortfolioCustomProperty;

/**
 * This class allow you to manage PortfolioCustomProperty
 * @see PortfolioCustomProperty
 * @package Omega\Plugin\Portfolio\Library\BLL
 */
class PortfolioCustomPropertyManager extends Manager
{
    /**
     * Get all CustomProperty
     * @see PortfolioCustomProperty
     * @return PortfolioCustomProperty[]
     */
    public static function GetAllCustonmProperties(){
        return PortfolioCustomPropertyDb::GetAllCustonmProperties();
    }

    /**
     * Get a CustomProperty by id
     * @see PortfolioCustomProperty
     * @param $id int The id
     * @return PortfolioCustomProperty
     */
    public static function GetCustomProperty($id){
        return PortfolioCustomPropertyDb::GetCustomProperty($id);
    }

    /**
     * Insert or update a CustomProperty
     * @see PortfolioCustomProperty
     * @param $entity PortfolioCustomProperty
     * @return bool True if success
     */
    public static function Save($entity) {
        if($entity->id == null)
            return PortfolioCustomPropertyDb::Insert($entity);
        else
            return PortfolioCustomPropertyDb::Update($entity);
    }

    /**
     * Delete a CustomPorperty by id
     * @param $id int The id
     * @return bool True if success
     */
    public static function Delete($id) {
        return PortfolioCustomPropertyDb::Delete($id);
    }
}