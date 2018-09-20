<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 05.03.2018
 * Time: 10:14
 */

namespace Omega\Plugin\News\Library\DAL;


use Omega\Library\DAL\Db;
use Omega\Library\DAL\Filler\EntityFiller;
use Omega\Plugin\News\Library\DTO\NewsPost;
use PDO;

class NewsPostDb extends Db
{
    public static function GetAllPosts(){
        return parent::GetAll(new NewsPost());
    }

    public static function GetAllPostsWithCategories($idCateogires, $count = null){
        $dbh = self::GetPDO();
        $query = "SELECT p.* FROM news_post_category AS pc
                    INNER JOIN news_post AS p ON pc.fkPost = p.id
                    WHERE pc.fkCategory IN(%s)
                    ORDER BY p.created DESC ";

        if(isset($count)) {
            $query .= " LIMIT 0, ".$count;
        }

        $query = sprintf($query, implode(",", $idCateogires));

        $stmt = $dbh->prepare($query);
        $stmt->execute();
        $entities = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $post = new NewsPost();
            EntityFiller::Fill($post, $row);
            $entities[] = $post;
        }
        return $entities;
    }

    public static function GetOlderPost($id, $categoriesId){

        $dbh = self::GetPDO();
        $query = "SELECT p.* FROM news_post_category AS pc
                    INNER JOIN news_post AS p ON pc.fkPost = p.id
                    WHERE pc.fkCategory IN(%s)
                    AND  p.created < (SELECT created FROM news_post WHERE id = :id)
                    ORDER BY p.created DESC 
                    LIMIT 0, 1";

        $query = sprintf($query, implode(",", $categoriesId));

        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $post = new NewsPost();
            EntityFiller::Fill($post, $row);
            return $post;
        }
        return null;
    }

    public static function GetNewerPost($id, $categoriesId)
    {
        $dbh = self::GetPDO();
        $query = "SELECT p.* FROM news_post_category AS pc
                    INNER JOIN news_post AS p ON pc.fkPost = p.id
                    WHERE pc.fkCategory IN(%s)
                    AND  p.created > (SELECT created FROM news_post WHERE id = :id)
                    ORDER BY p.created ASC 
                    LIMIT 0, 1";

        $query = sprintf($query, implode(",", $categoriesId));

        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $post = new NewsPost();
            EntityFiller::Fill($post, $row);
            return $post;
        }
        return null;
    }

    public static function GetPost($id){
        return parent::GetOne(new NewsPost(), $id);
    }

    public static function Insert($entity) {
        return parent::Insert($entity);
    }

    public static function Update($entity) {
        return parent::Update($entity);
    }

    public static function Delete($id){
        return parent::DeleteWhere(new NewsPost(), $id);
    }
}