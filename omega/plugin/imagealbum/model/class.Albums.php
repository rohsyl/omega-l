<?php
namespace Omega\Plugin\Imagealbum\Model;

use Omega\Library\Database\Dbs;
use Omega\Library\Mvc\Model;
use Omega\Library\Util\Config;



class Albums extends Model {

    public static function getConfig(){
        $defaultConfig = json_decode(Config::get('imagealbum_config_defaults'), true);
        $config = Config::get('imagealbum_config');
        if(empty($config)) $config = array();
        else $config = json_decode($config, true);
        $cfg = array_merge($defaultConfig, $config);
        return $cfg;
    }


    // SECEGORY
    public static function getAllSections(){
        return self::getAllOrder(TABLE_SECTION, SEC_ORDER);
    }

    public static function getSection($id){
        return self::get(TABLE_SECTION, SEC_ID, $id);
    }

    public static function saveSection($category){
        return self::saveOne(TABLE_SECTION, SEC_ID, $category);
    }

    public static function deleteSection($id){
        self::delete(TABLE_SECTION, SEC_ID, $id);
    }
    // END SECEGORY

    // ALB
    public static function getAllAlbums($id){
        return self::getAllWhereOrder(TABLE_ALB, ALB_SEC, $id, ALB_YEAR, 'DESC');
    }

    public static function getAlbum($id){
        return self::get(TABLE_ALB, ALB_ID, $id);
    }

    public static function saveAlbum($item){
        return self::saveOne(TABLE_ALB, ALB_ID, $item);
    }

    public static function deleteAlbum($id){
        self::delete(TABLE_ALB, ALB_ID, $id);
    }
    // END ALB

    // IMAGE
    public static function getAllImage($id){
        return self::getAllWhereOrder(TABLE_IMG, IMG_ALBUM, $id, IMG_ORDER, 'ASC');
    }

    public static function saveImage($image){
        return self::saveOne(TABLE_IMG, IMG_ID, $image);
    }

    public static function deleteImage($id){
        return self::delete(TABLE_IMG, IMG_ID, $id);
    }
    // END IMAGE

    private static function getAllOrder($table, $order){
        $o = Dbs::select('*')
            ->from($table)
            ->orderby($order, 'ASC')
            ->run()
            ->getAllArray();
        return $o;
    }
    private static function getAllWhereOrder($table, $colwhere, $valuewhere, $colorder, $typeorder){
        $o = Dbs::select('*')
            ->from($table)
            ->where($colwhere, '=', $valuewhere)
            ->orderby($colorder, $typeorder)
            ->run()
            ->getAllArray();
        return $o;
    }

    private static function get($table, $cid, $id){
        $stmt = Dbs::select('*')
            ->from($table)
            ->where($cid, '=', $id)
            ->run();
        $o = $stmt->length() > 0 ? $stmt->getRowArray(0) : null;
        return $o;
    }

    private static function saveOne($table, $cid, $values){
        $id = isset($values[$cid]) ? $values[$cid] : null;
        unset($values[$cid]);
        $m = new Model();
        return $m->save($table, $values, $id);
    }

    private static function delete($table, $cid, $id){
        return Dbs::delete($table)
            ->where($cid, '=', $id)
            ->run();
    }
}