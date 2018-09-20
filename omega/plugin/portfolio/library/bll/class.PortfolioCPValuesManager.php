<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 15.03.2018
 * Time: 11:19
 */

namespace Omega\Plugin\Portfolio\Library\BLL;


use Omega\Plugin\Portfolio\Library\DAL\PortfolioCPValuesDb;
use Omega\Plugin\Portfolio\Library\DTO\PortfolioCustomProperty;
use Omega\Plugin\Portfolio\Library\DTO\PortfolioCustomPropertyValue;

class PortfolioCPValuesManager
{
    /**
     * Get all existing values for an item
     * @param $itemId int The id of the portfolio item
     * @return PortfolioCustomPropertyValue[]
     */
    public static function GetAllCPValues($itemId){
        return PortfolioCPValuesDb::GetAllCPValues($itemId);
    }


    /**
     * Get all the values with the property. The value is created if not already existant.
     * @param $itemId int The id of the item
     * @return PortfolioCustomPropertyValue[]
     */
    public static function GetValuesWithProperty($itemId){
        $properties = PortfolioCustomPropertyManager::GetAllCustonmProperties();
        $values = array();
        foreach($properties as $property)
        {
            $value = null;
            if(self::Exists($property->id, $itemId)) {
                $value = self::GetCPValueByItemAndProperty($property->id, $itemId);
            }
            else
            {
                $value = new PortfolioCustomPropertyValue();
                $value->value = "";
                $value->fkCustomProperty = $property->id;
                $value->fkItem = $itemId;
                self::Save($value);
            }
            $value->property = $property;
            $values[] = $value;
        }
        return $values;
    }

    /**
     * Get a value by id
     * @param $valueId int The id
     * @return PortfolioCustomPropertyValue
     */
    public static function GetCPValue($valueId){
        return PortfolioCPValuesDb::GetCPValue($valueId);
    }

    /**
     * Get a value by item and porperty id
     * @param $propertyId int The property id
     * @param $itemId int The item id
     * @return PortfolioCustomPropertyValue|null
     */
    public static function GetCPValueByItemAndProperty($propertyId, $itemId){
        return PortfolioCPValuesDb::GetCPValueByItemAndProperty($propertyId, $itemId);
    }

    /**
     * Insert or Update a value
     * @param $entity PortfolioCustomPropertyValue
     * @return bool True if success
     */
    public static function Save($entity) {
        if($entity->id == null)
            return PortfolioCPValuesDb::Insert($entity);
        else
            return PortfolioCPValuesDb::Update($entity);
    }

    /**
     * Check if a value exists
     * @param $propertyId int The property id
     * @param $itemId int The item id
     * @return bool True if exists
     */
    public static function Exists($propertyId, $itemId){
        return PortfolioCPValuesDb::Exists($propertyId, $itemId);
    }
}