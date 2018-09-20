<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 05.03.2018
 * Time: 11:03
 */

namespace Omega\Plugin\News\Library\BLL;


use Omega\Library\BLL\Manager;
use Omega\Plugin\News\Library\DAL\NewsPostCategoryDb;

class NewsPostCategoryManager extends Manager
{
    /**
     * Get all category/post relation for a given post
     * @param $idPost int The id of the post
     * @return NewsPostCategory[]
     */
    public static function GetAllByPost($idPost){
        return NewsPostCategoryDb::GetAllByPost($idPost);
    }

    /**
     * Add a post in a category
     * @param $idPost int The id of the post
     * @param $idCategory int The id of the category
     * @return bool True if success
     */
    public static function AddPostInCategory($idPost, $idCategory){
        return NewsPostCategoryDb::AddPostInCategory($idPost, $idCategory);
    }

    /**
     * Remove a post from all categories
     * @param $idPost int The id of the post
     * @return bool True if success
     */
    public static function RemovePostFromAllCategories($idPost){
        return NewsPostCategoryDb::RemovePostFromAllCategories($idPost);
    }

    /**
     * Remove a post from a category
     * @param $idPost
     * @param $idCategory
     * @return bool
     */
    public static function RemovePostFromCategory($idPost, $idCategory){
        return NewsPostCategoryDb::RemovePostFromCategory($idPost, $idCategory);
    }


    /**
     * Remove all post from a category
     * @param $idPost
     * @param $idCategory
     * @return bool
     */
    public static function RemoveAllPostFromCategory($idCategory){
        return NewsPostCategoryDb::RemoveAllPostFromCategory($idCategory);
    }
}