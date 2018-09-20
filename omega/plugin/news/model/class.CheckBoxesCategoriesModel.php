<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 05.03.2018
 * Time: 17:38
 */

namespace Omega\Plugin\News\Model;


use Omega\Library\Plugin\Type\CheckBoxes\ACheckBoxesModel;
use Omega\Plugin\News\Library\BLL\NewsCategoryManager;

class CheckBoxesCategoriesModel extends ACheckBoxesModel {

    public  function getKeyValueArray() {
        $categories = NewsCategoryManager::GetAllCategories();

        $kv = array();
        foreach ($categories as $c){
            $kv[$c->id] = $c->name;
        }
        return $kv;
    }
}