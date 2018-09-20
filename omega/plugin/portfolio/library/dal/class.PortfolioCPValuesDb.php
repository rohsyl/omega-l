<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 15.03.2018
 * Time: 08:46
 */

namespace Omega\Plugin\Portfolio\Library\DAL;

use Omega\Library\DAL\Db;
use Omega\Library\DAL\Filler\EntityFiller;
use Omega\Plugin\Portfolio\Library\DTO\PortfolioCustomProperty;
use Omega\Plugin\Portfolio\Library\DTO\PortfolioCustomPropertyValue;
use PDO;

class PortfolioCPValuesDb extends Db
{
    public static function GetAllCPValues($itemId){
        return parent::GetManyWhere(new PortfolioCustomProperty(), $itemId, 'fkItem');
    }

    public static function GetCPValue($valueId){
        return parent::GetOne(new PortfolioCustomPropertyValue(), $valueId);
    }

    public static function GetCPValueByItemAndProperty($propertyId, $itemId){
        $dbh = parent::GetPDO();
        $stmt = $dbh->prepare('SELECT * FROM pf_cp_values WHERE fkCustomProperty = :fkCustomProperty AND fkItem = :fkItem');
        $stmt->bindParam(':fkCustomProperty', $propertyId);
        $stmt->bindParam(':fkItem', $itemId);
        $stmt->execute();

        $entity = null;
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $entity = new PortfolioCustomPropertyValue();
            EntityFiller::Fill($entity, $row);
        }
        return $entity;
    }

    public static function Insert($entity) {
        return parent::Insert($entity);
    }

    public static function Update($entity) {
        return parent::Update($entity);
    }

    public static function Exists($propertyId, $itemId){
        $dbh = parent::GetPDO();
        $stmt = $dbh->prepare('SELECT COUNT(*) FROM pf_cp_values WHERE fkCustomProperty = :fkCustomProperty AND fkItem = :fkItem');
        $stmt->bindParam(':fkCustomProperty', $propertyId);
        $stmt->bindParam(':fkItem', $itemId);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}