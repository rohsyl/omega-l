<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 17.09.18
 * Time: 08:40
 */

namespace Omega\Repositories;


use Illuminate\Support\Facades\Auth;
use Omega\Models\Page;
use Omega\Library\Entity\Page as PageHelper;

class PageRepository
{

    private $page;

    public function __construct(Page $page) {
        $this->page = $page;
    }

    public function get($id){
        return $this->page->find($id);
    }

    public function all($langSlug = null){
        if(isset($langSlug)){
            return $this->page->where('lang', $langSlug)->get();
        }
        else{
            return $this->page->get();
        }
    }

    public function getPagesWithParent($idPageParent = null){
        if(!isset($idPageParent))
            return $this->page->whereNull('fkPageParent')->get();
        else
            return $this->page->where('fkPageParent', $idPageParent)->get();
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

    public function getCorrespondingParents($langs, $page){
        $corr = array();
        foreach ($langs as $l){
            if($l->slug != $page->lang){
                if($page->fkPageParent == null || $page->fkPageParent == 0){
                    $corr[$l->slug] = null;
                }
                else{
                    $corr[$l->slug] = PageHelper::GetCorrespondingInLang($page->fkPageParent, $l->slug);
                }
            }
        }
        return $corr;
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

    public function update($page, $inputs){
        $page->showName = $inputs['showName'];
        $page->name = $inputs['name'];
        $page->showSubtitle = $inputs['showSubtitle'];
        $page->subtitle = $inputs['subtitle'];
        $page->slug = $inputs['slug'];
        $page->model = $inputs['model'];
        $page->cssTheme = $inputs['cssTheme'];
        $page->keyWords = $inputs['keyword'];
        $page->fkMenu = $inputs['menu'];
        $page->fkPageParent = $inputs['parent'];
        if(om_config('om_enable_front_langauge')){
            $page->lang = real_null($inputs['lang']);

        }

        $page->save();
        return $page;
    }
}