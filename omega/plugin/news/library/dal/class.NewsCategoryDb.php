<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 05.03.2018
 * Time: 10:23
 */

namespace Omega\Plugin\News\Library\DAL;


use Omega\Library\DAL\Db;
use Omega\Library\DAL\Filler\EntityFiller;
use Omega\Plugin\News\Library\DTO\NewsCategory;
use Omega\Plugin\News\Library\DTO\NewsPost;
use PDO;

class NewsCategoryDb extends Db
{
    public static function GetAllCategories(){
        return parent::GetAll(new NewsCategory());
    }

    public static function GetAllCategoriesOfPost($idPost){
        $dbh = self::GetPDO();
        $query = "SELECT c.* FROM news_post_category AS pc
                INNER JOIN news_category AS c ON pc.fkCategory = c.id
                WHERE pc.fkPost = :fkPost";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':fkPost', $idPost);
        $stmt->execute();
        $entities = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $post = new NewsCategory();
            EntityFiller::Fill($post, $row);
            $entities[] = $post;
        }
        return $entities;
    }

    public static function GetCategory($id){
        return parent::GetOne(new NewsCategory(), $id);
    }

    public static function Insert($entity) {
        return parent::Insert($entity);
    }

    public static function Update($entity) {
        return parent::Update($entity);
    }

    public static function Delete($id){
        return parent::DeleteWhere(new NewsCategory(), $id);
    }
}