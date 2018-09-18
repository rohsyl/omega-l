<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 17.09.18
 * Time: 08:40
 */

namespace Omega\Repositories;


use Illuminate\Support\Facades\Auth;
use Omega\Page;

class PageRepository
{

    private $page;

    public function __construct(Page $page) {
        $this->page = $page;
    }

    public function getPagesWithParent($idPageParent = null){
        if(!isset($idPageParent))
            $query = $this->page->whereNull('fkPageParent');
        else
            $query = $this->page->where('fkPageParent', $idPageParent);

        return $query->get();
    }

    public function getPageWithParentAndLang($langSlug, $idPageParent = null){
        $query = $this->page->where('lang', $langSlug);
        if(isset($idPageParent)){
            $query = $query->where('fkPageParent', $idPageParent);
        }
        else
            $query = $query->where('fkPageParent', $idPageParent);

        return $query->get();
    }

    public function hasChild($fkPageParent){
        return $this->page->where('fkPageParent', $fkPageParent)->count() > 0;
    }

    public function create($inputs){
        $page = new Page();
        $page->name = $inputs['name'];
        $page->slug = unique_slug($page, $page->name);
        if(isset($inputs['lang']))
            $page->lang = $inputs['lang'];
        $page->fkPageParent = $inputs['parent'];
        $page->fkUser = Auth::id();
        return $page->save();
    }
}