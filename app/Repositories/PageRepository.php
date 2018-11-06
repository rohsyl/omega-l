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
     * @param $slug strin
     * @return Page|null
     */
    public function getBySlug($slug){
        return $this->page->where('slug', $slug)->first();
    }

    /**
     * Soft-delete a page
     * @param $id int
     * @return int
     */
    public function delete($id){
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

    /**
     * Get all page where the parent is given
     * @param int|null $idPageParent
     * @return mixed
     */
    public function getPagesWithParent($idPageParent = null){
        if(!isset($idPageParent))
            return $this->page->whereNull('fkPageParent')->get();
        else
            return $this->page->where('fkPageParent', $idPageParent)->get();
    }

    /**
     * Get all page with the given parent and the given lang
     * @param $langSlug string The slug of the lang
     * @param int|null $idPageParent The id of the parent or null
     * @return mixed
     */
    public function getPageWithParentAndLang($langSlug, $idPageParent = null){
        $query = $this->page->where('lang', $langSlug);
        if(isset($idPageParent)){
            $query = $query->where('fkPageParent', $idPageParent);
        }
        else
            $query = $query->where('fkPageParent', $idPageParent);

        return $query->get();
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
        $page->slug = unique_slug($page, str_slug($page->name));
        if(isset($inputs['lang']))
            $page->lang = $inputs['lang'];
        $page->fkPageParent = $inputs['parent'];
        $page->fkUser = Auth::id();
        return $page->save();
    }

    /**
     * Update a page
     * @param $page
     * @param $inputs
     * @return mixed
     */
    public function update($page, $inputs){
        $page->showName = $inputs['showName'];
        $page->name = $inputs['name'];
        $page->showSubtitle = $inputs['showSubtitle'];
        $page->subtitle = $inputs['subtitle'];
        $page->slug = unique_slug($page, str_slug($inputs['slug']));
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