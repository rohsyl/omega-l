<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 05.03.2018
 * Time: 17:38
 */

namespace OmegaPlugin\News\Model;


use Omega\Utils\Plugin\Type\CheckBoxes\ACheckBoxesModel;
use OmegaPlugin\News\Models\Category;
use OmegaPlugin\news\Repository\CategoryRepository;

class CheckBoxesCategoriesModel extends ACheckBoxesModel {

    private $categoryRepository;

    public function __construct($entry)
    {
        parent::__construct($entry);
        $this->categoryRepository = new CategoryRepository(new Category());
    }

    public  function getKeyValueArray() {
        $categories = $this->categoryRepository->all();
        $kv = array();
        foreach ($categories as $c){
            $kv[$c->id] = $c->name;
        }
        return $kv;
    }
}