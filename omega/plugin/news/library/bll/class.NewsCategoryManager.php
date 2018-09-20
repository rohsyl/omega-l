<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 05.03.2018
 * Time: 11:00
 */

namespace Omega\Plugin\News\Library\BLL;


use Omega\Plugin\News\Library\DAL\NewsCategoryDb;
use Omega\Plugin\News\Library\DTO\NewsCategory;

class NewsCategoryManager
{
    /**
     * Get all categories
     * @see NewsCategory
     * @return array<NewsCategory>
     */
    public static function GetAllCategories(){
        return NewsCategoryDb::GetAllCategories();
    }

    /**
     * Get a category
     * @param $id int The id of the category
     * @return NewsCategory|null
     */
    public static function GetCategory($id){
        return NewsCategoryDb::GetCategory($id);
    }

    /**
     * Get all  categories that contains a post
     * @param $idPost int The id of the post
     * @return array<NewsCategory>
     */
    public static function GetAllCategoriesOfPost($idPost){
        return NewsCategoryDb::GetAllCategoriesOfPost($idPost);
    }

    /**
     * Insert or Update a category
     * @param $category NewsCategory The category
     * @return bool True if success
     */
    public static function Save($category) {
        if($category->id == null)
            return NewsCategoryDb::Insert($category);
        else
            return NewsCategoryDb::Update($category);

    }

    /**
     * Delete a category
     * @param $id int The id of the category
     * @return bool True if success
     */
    public static function Delete($id){
        return NewsCategoryDb::Delete($id);
    }
}