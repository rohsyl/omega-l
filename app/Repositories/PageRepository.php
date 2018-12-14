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
use Omega\Utils\Entity\Page as PageHelper;

class PageRepository
{

    private $paginateNb;
    private $trashPaginateNb;

    private $page;

    public function __construct(Page $page) {
        $this->page = $page;
        $this->paginateNb = config('omega.page.paginate');
        $this->trashPaginateNb = config('omega.page.trash.paginate');
    }

    /**
     * Get a page by id
     * @param $id int
     * @return Page|null
     */
    public function get($id){
        return $this->page->find($id);
    }

    /**
     * Get a page by slug
     * @param $slug string
     * @return Page|null
     */
    public function getBySlug($slug){
        return $this->page->where('slug', $slug)->first();
    }

    /**
     * Get a page by slug and lang
     * @param $slug string
     * @param $lang string Language slug
     * @return Page|null
     */
    public function getBySlugAndLang($slug, $lang){
        return $this->page->where('slug', $slug)->where('lang', $lang)->first();
    }

    /**
     * Soft-delete a page
     * @param $id int
     * @return int
     */
    public function delete($id){
        $page = $this->get($id);
        $page->slug = str_random(10);
        $page->save();

        foreach($page->children as $child){
            $child->slug = str_random(10);
            $child->save();
            $this->page->destroy($child->id);
        }

        return $this->page->destroy($id);
    }

    /**
     * Get all pages, filtered by lang
     * @param null $langSlug If not null, filter by lang (lang.slug)
     * @return mixed
     */
    public function all($langSlug = null){
        if(isset($langSlug)){
            return $this->page->where('lang', $langSlug)->get();
        }
        else{
            return $this->page->get();
        }
    }

    private function getDeletedPages(){
        return Page::onlyTrashed()->orderBy('deleted_at', 'DESC');
    }

    public function deleted(){
        return $this->getDeletedPages()->get();
    }


    public function deleted_paginate(){
        return $this->getDeletedPages()->paginate($this->trashPaginateNb);
    }

    public function restore($id){
        return $this->getTrashed($id)->restore();
    }

    public function forcedelete($id){
        $page = $this->getTrashed($id);
        $page->modules()->forceDelete();
        return $page->forceDelete();
    }

    public function getTrashed($id){
        return Page::onlyTrashed()->find($id);
    }

    public function getLastUpdatedPages($limit){
        return $this->page->orderBy('updated_at', 'DESC')->limit($limit)->get();
    }

    /**
     * Get all page where the parent is given
     * @param int|null $idPageParent
     * @return mixed
     */
    public function getPagesWithParent($idPageParent = null){
        return $this->pagesWithParent($idPageParent)->get();
    }

    /**
     * Get all page where the parent is given paginate
     * @param int|null $idPageParent
     * @return mixed
     */
    public function paginatePagesWithParent($idPageParent = null){
        return $this->pagesWithParent($idPageParent)->paginate($this->paginateNb);
    }


    /**
     * Get all page where the parent is given
     * @param null $idPageParent
     * @return mixed
     */
    private function pagesWithParent($idPageParent = null){
        $query = null;
        if(!isset($idPageParent))
            $query = $this->page->whereNull('fkPageParent');
        else
            $query = $this->page->where('fkPageParent', $idPageParent);
        return $query->orderBy('order');
    }

    /**
     * Get all page with the given parent and the given lang
     * @param $langSlug string The slug of the lang
     * @param int|null $idPageParent The id of the parent or null
     * @return mixed
     */
    public function getPageWithParentAndLang($langSlug, $idPageParent = null){
        return $this->pageWithParentAndLang($langSlug, $idPageParent)->get();
    }

    /**
     * Get all page with the given parent and the given lang
     * @param $langSlug string The slug of the lang
     * @param int|null $idPageParent The id of the parent or null
     * @return mixed
     */
    public function paginatePageWithParentAndLang($langSlug, $idPageParent = null){
        return $this->pageWithParentAndLang($langSlug, $idPageParent)->paginate($this->paginateNb);
    }


    private function pageWithParentAndLang($langSlug, $idPageParent = null){
        $query = $this->page->where('lang', $langSlug);
        if(isset($idPageParent)){
            $query = $query->where('fkPageParent', $idPageParent);
        }
        else
            $query = $query->whereNull('fkPageParent');

        return $query->orderBy('order');
    }
    /**
     * Get the parent of the page in the corresponding lang for each lang
     * @param $langs
     * @param $page
     * @return array
     */
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

    /**
     * Return true if the given page has child
     * @param $fkPageParent
     * @return bool
     */
    public function hasChild($idPage){
        return $this->page->where('fkPageParent', $idPage)->count() > 0;
    }

    /**
     * Create a page
     * @param $inputs
     * @return bool
     */
    public function create($inputs){
        $page = new Page();
        $page->name = $inputs['name'];
        $page->showSubtitle = false;
        $page->slug = unique_slug($page, str_slug($page->name));
        if(isset($inputs['lang']))
            $page->lang = $inputs['lang'];
        $page->model = 'default';
        $page->fkPageParent = $inputs['parent'];
        $page->fkUser = Auth::id();
        return $page->save();
    }

    /**
     * Update a page
     * @param $page
     * @param $inputs
     * @param $beforeSaveClosure \Closure
     * @return mixed
     */
    public function update($page, $inputs, $beforeSaveClosure = null){

        $name = $inputs['name'];
        // TODO : unique slug
        //$slug = unique_slug($page, str_slug($inputs['slug']));
        $slug = $inputs['slug'];

        $lang = real_null($inputs['lang']);

        // callback to update name and slug in menus
        if(isset($beforeSaveClosure))
            $beforeSaveClosure($name, $slug, $lang, $page);

        $page->showName = $inputs['showName'];
        $page->name = $name;
        $page->showSubtitle = $inputs['showSubtitle'];
        $page->subtitle = $inputs['subtitle'];
        $page->slug = $slug;
        $page->model = $inputs['model'];
        $page->cssTheme = $inputs['cssTheme'];
        $page->keyWords = $inputs['keyword'];
        $page->fkMenu = $inputs['menu'];
        $page->fkPageParent = $inputs['parent'];
        if(om_config('om_enable_front_langauge')){
            $page->lang = $lang;

        }

        $page->save();
        return $page;
    }

    /**
     * Enable or disable a page
     * @param $page Page The page
     * @param $enabled boolean
     */
    public function enable($page, $enabled){
        $page->isEnabled = $enabled;
        $page->save();
    }
}