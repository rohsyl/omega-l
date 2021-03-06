<?php
namespace OmegaPlugin\LangRedirect\Model;


use Omega\Models\Page;
use Omega\Repositories\PageRepository;
use Omega\Utils\Plugin\Type\DropDown\ADropDownModel;

class DropDownPage extends ADropDownModel {

    private $pageRepository;

    public function __construct($entry) {
        parent::__construct($entry);
        $this->pageRepository = new PageRepository(new Page());
    }

    public  function getKeyValueArray() {

        $pages = $this->pageRepository->all();

        $keyvalue = [];
        $keyvalue['null'] = __('Choose a page');
        if(sizeof($pages) > 0){
            foreach($pages as $page){
                $keyvalue[$page->id] = $page->name;
            }
        }
        return $keyvalue;
    }
}