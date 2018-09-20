<?php
namespace Omega\Plugin\Completedemoplugin\Model;


use Omega\Library\BLL\PageManager;
use Omega\Library\Plugin\Type\CheckBoxes\ACheckBoxesModel;

class CheckBoxesPage extends ACheckBoxesModel {

    public  function getKeyValueArray() {

        $pages = PageManager::GetAllPages();

        $kv = array();
        foreach ($pages as $c){
            $kv[$c->id] = $c->pageName;
        }
        return $kv;
    }
}