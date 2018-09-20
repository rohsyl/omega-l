<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 05.03.2018
 * Time: 10:32
 */

namespace Omega\Plugin\News\Library\BLL;


use Omega\Library\BLL\Manager;
use Omega\Plugin\News\Library\DAL\NewsPostDb;
use Omega\Plugin\News\Library\DTO\NewsPost;

class NewsPostManager extends Manager
{
    /**
     * Get all posts
     * @see NewsPost
     * @return array<NewsPost>|null An array of NewsPost
     */
    public static function GetAllPosts(){
        return NewsPostDb::GetAllPosts();
    }

    /**
     * Get all posts of the given cateogies
     * @param $categoriesId array An array of category id
     * @param $count int|null The limit of posts to get. If null, no limit
     * @return NewsPost[] An array of NewsPost
     */
    public static function GetAllPostsWithCategories($categoriesId, $count = null){
        return NewsPostDb::GetAllPostsWithCategories($categoriesId, $count);
    }

    /**
     * Get a post
     * @param $id int The id of the post
     * @return NewsPost|null
     */
    public static function GetPost($id){
        return NewsPostDb::GetPost($id);
    }

    public static function GetOlderPost($id , $categoriesId) {
        return NewsPostDb::GetOlderPost($id, $categoriesId);
    }

    public static function GetNewerPost($id, $categoriesId) {
        return NewsPostDb::GetNewerPost($id, $categoriesId);
    }


    /**
     * Insert or Update a post
     * @param $newsPost NewsPost The post
     * @return bool True if success
     */
    public static function Save($newsPost) {
        if($newsPost->id == null)
            return NewsPostDb::Insert($newsPost);
        else
            return NewsPostDb::Update($newsPost);
    }

    /**
     * Delete a post by id
     * @param $id int The id of the post
     * @return bool True if success
     */
    public static function Delete($id){
        return NewsPostDb::Delete($id);
    }
}