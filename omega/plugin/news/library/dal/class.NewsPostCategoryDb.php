<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 05.03.2018
 * Time: 11:02
 */

namespace Omega\Plugin\News\Library\DAL;


use Omega\Library\DAL\Db;
use Omega\Plugin\News\Library\DTO\NewsPostCategory;

class NewsPostCategoryDb extends Db
{

    public static function GetAllByPost($idPost){
        return self::GetManyWhere(new NewsPostCategory(), $idPost, 'fkPost');
    }

    public static function AddPostInCategory($idPost, $idCategory){
        $npc = new NewsPostCategory();
        $npc->fkPost = $idPost;
        $npc->fkCategory = $idCategory;
        return parent::Insert($npc);
    }

    public static function RemovePostFromAllCategories($idPost){
        return parent::DeleteWhere(new NewsPostCategory(), $idPost, 'fkPost');
    }

    public static function RemoveAllPostFromCategory($idCategory){
        return parent::DeleteWhere(new NewsPostCategory(), $idCategory, 'fkCategory');
    }

    public static function RemovePostFromCategory($idPost, $idCategory){
        $entity = new NewsPostCategory();
        $tableName = $entity->getTableName();

        $dbh = self::GetPDO();
        $query = sprintf('DELETE FROM %s WHERE fkPost = :fkPost  AND fkCategory = :fkCategory', $tableName);

        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':fkPost', $idPost);
        $stmt->bindParam(':fkCategory', $idCategory);
        return $stmt->execute();
    }
}