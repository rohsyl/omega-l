<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 17.10.18
 * Time: 10:22
 */

namespace Omega\Repositories;


use Illuminate\Support\Facades\DB;
use Omega\Models\PageLangRel;

class PageLangRelRepository
{
    private $pagelangrel;

    public function __construct(PageLangRel $pagelangrel)
    {
        $this->pagelangrel = $pagelangrel;
    }

    public function clearRelIfLangChanged($page, $inputs){
        if($page->lang != $inputs['lang']){
            $this->deleteByPage($page->id);
        }
    }

    public function savePageLangRel($idPage1, $idPage2, $lang) {

        $this->deleteLangRel($idPage1, $lang);
        $this->addLangRel($idPage1, $idPage2);
    }

    private function deleteLangRel($idPage, $lang){
        $result = DB::delete(
     "DELETE R.* FROM page_lang_rels AS R
            INNER JOIN pages AS P1 ON P1.id = R.fkPage1
            INNER JOIN pages AS P2 ON P2.id = R.fkPage2
            WHERE 
            (R.fkPage1 = ? AND P2.lang = ?) 
            OR 
            (R.fkPage2 = ? AND P1.lang = ?)",
            [
                $idPage, $lang, $idPage, $lang
            ]
        );
        return $result;
    }

    private function addLangRel($idPage, $fkPage){
        if(isset($fkPage)){
            $plr1 = new PageLangRel();
            $plr1->fkPage1 = $idPage;
            $plr1->fkPage2 = $fkPage;
            $plr1->save();

            $plr2 = new PageLangRel();
            $plr2->fkPage2 = $idPage;
            $plr2->fkPage1 = $fkPage;
            $plr2->save();

            return true;
        }
        return false;
    }

    public function deleteByPage($pageId){

        $result = DB::delete(
     "DELETE R.* FROM page_lang_rels AS R
            WHERE R.fkPage1 = ? OR R.fkPage2 = ?",
            [
                $pageId, $pageId
            ]
        );
        return $result;
    }
}