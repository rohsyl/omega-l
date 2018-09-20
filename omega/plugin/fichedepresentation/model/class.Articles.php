<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 20.10.2017
 * Time: 10:11
 */
namespace Omega\Plugin\Fichedepresentation\Model;

use Omega\Library\Database\Dbs;
use Omega\Library\Util\Ini;
use PDO;

class Articles
{
    private static function getConnexion(){
        $db_host = Ini::Get('plugin.fichedepresentation.host');
        $db_name = Ini::Get('plugin.fichedepresentation.name');
        $db_user = Ini::Get('plugin.fichedepresentation.user');
        $db_pass = Ini::Get('plugin.fichedepresentation.pass');

        $pdo = Dbs::getConnexion($db_host, $db_name, $db_user, $db_pass);
        return $pdo;
    }

    public static function getAll() {
        $pdo = self::getConnexion();
        $data = $pdo->query('SELECT article, designation FROM tdliste_materiel WHERE valide = 1');
        $datas = $data->fetchAll(PDO::FETCH_ASSOC);
        $articles = array();
        foreach($datas as $a){
            if($a['article'] != 0)
                $articles[] = new Article($a['article'], $a['designation']);
        }
        return $articles;
    }

    public static function getOne($ref){
        $ref = $_GET['ref'];
        $pdo = self::getConnexion();
        $data = $pdo->query('SELECT article, designation FROM tdliste_materiel WHERE article = '.$ref);
        $datas = $data->fetchAll(PDO::FETCH_ASSOC);
        if(sizeof($datas) > 0){
            $a = $datas[0];
            return new Article($a['article'], $a['designation']);
        }
        return null;
    }

}


