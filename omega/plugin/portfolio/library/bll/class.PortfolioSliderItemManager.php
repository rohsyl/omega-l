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
use Omega\Plugin\Portfolio\Library\DAL\PortfolioSliderItemDb;
use Omega\Plugin\Portfolio\Library\DTO\PortfolioItem;
use Omega\Plugin\Portfolio\Library\DTO\PortfolioSliderItem;
use Omega\Plugin\Portfolio\Model\PortfolioItemSlider;

/**
 * This class allow you to manage PortfolioSliderItem
 * @package Omega\Plugin\Portfolio\Library\BLL
 */
class PortfolioSliderItemManager extends Manager
{
    /**
     * Get all slideritem for a portfolioitem
     * @param $idPortfolioItem int The id of the portfolio item
     * @return PortfolioSliderItem[]
     */
    public static function GetAllSliderItems($idPortfolioItem){
        return PortfolioSliderItemDb::GetAllSliderItems($idPortfolioItem);
    }

    /**
     * Add a SliderItem for a Portfolio item
     * @param $idItem int The id of the portfolio item
     * @return bool True if success
     */
    public static function AddSliderItem($idItem){
        return PortfolioSliderItemDb::AddSliderItem($idItem);
    }

    /**
     * Save a SliderItem
     * @param $entity PortfolioItemSlider The slider item
     * @return bool True if success
     */
    public static function SaveSliderItem($entity) {
        return PortfolioSliderItemDb::SaveSliderItem($entity);
    }

    /**
     * Delete a slideritem by id
     * @param $id int The id
     * @return bool True if success
     */
    public static function Delete($id){
        return PortfolioSliderItemDb::Delete($id);
    }

    /**
     * Delete all slider item for a portfolio item
     * @param $idPortfolioItem int The id of the portfolio item
     * @return bool True if success
     */
    public static function DeleteAllSliderItem($idPortfolioItem){
        return PortfolioSliderItemDb::DeleteAllSliderItem($idPortfolioItem);
    }
}