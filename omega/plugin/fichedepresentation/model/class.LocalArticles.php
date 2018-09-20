<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 20.10.2017
 * Time: 13:21
 */
namespace Omega\Plugin\Fichedepresentation\Model;

use Omega\Library\Database\Dbs;
use Omega\Library\Mvc\Model;

class LocalArticles
{
    public static function getAll(){
        $stmt = Dbs::select('*')
            ->from('pres_article')
            ->orderby('ref', 'ASC')
            ->run();

        $datas = $stmt->getAllArray();
        $articles = array();
        foreach($datas as $d){
            $i = new LocalArticle();
            $i->id = $d['id'];
            $i->fkMediaImage = $d['fkMediaImage'];
            $i->fkMediaPres = $d['fkMediaPres'];
            $i->fkMediaPanel = $d['fkMediaPanel'];
            $i->ref = $d['ref'];
            $i->name = $d['name'];
            $articles[$i->ref] = $i;
        }
        return $articles;
    }


    public static function getOne($id){
        $stmt = Dbs::select('*')
            ->from('pres_article')
            ->where('id', '=', '?')
            ->prepare(array($id))
            ->run();

        if($stmt->length() > 0){
            $d = $stmt->getRowArray(0);
            $i = new LocalArticle();
            $i->id = $d['id'];
            $i->fkMediaImage = $d['fkMediaImage'];
            $i->fkMediaPres = $d['fkMediaPres'];
            $i->fkMediaPanel = $d['fkMediaPanel'];
            $i->ref = $d['ref'];
            $i->name = $d['name'];
            return $i;
        }
        return null;
    }

    public static function save($localArticle){
        $model = new Model();
        $data = array(
            'fkMediaImage' => $localArticle->fkMediaImage,
            'fkMediaPres' => $localArticle->fkMediaPres,
            'fkMediaPanel' => $localArticle->fkMediaPanel,
            'ref' => $localArticle->ref,
            'name' => $localArticle->name
        );
        if($localArticle->id == null){
            //insert
            $model->save('pres_article', $data);
        }
        else{
            // update
            $model->save('pres_article', $data, $localArticle->id);
        }
    }

    public static function delete($id){
        $res = Dbs::delete('pres_article')
            ->where('id', '=', $id)
            ->run();
        return $res;
    }
}