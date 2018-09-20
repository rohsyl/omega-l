<?php
namespace Omega\Plugin\DividedContent\Model;

use Omega\Library\BLL\PageManager;
use Omega\Library\Plugin\Type\DropDown\ADropDownModel;
use Omega\Library\Database\Dbs;
use function Omega\Library\__;

class DropDownPage extends ADropDownModel{

    public  function getKeyValueArray() {

        $pages = PageManager::GetAllPagesWithParent($this->getEntry()->getIdPage());

        $keyvalue = array();
        $keyvalue['null'] = __('Choose a page', true);
        if(sizeof($pages) > 0){
            foreach($pages as $page){
                $keyvalue[$page->id] = $page->pageName;
            }
        }
        return $keyvalue;
    }
}