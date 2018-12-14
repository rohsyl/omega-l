<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 18.09.18
 * Time: 12:59
 */

namespace Omega\Repositories;

use Omega\Models\Menu;
use Omega\Models\Page;

class MenuRepository
{
    private $menu;

    public function __construct(Menu $menu) {
        $this->menu = $menu;
    }

    /**
     * Get menu by id
     * @param $id int The id
     * @return Menu|null
     */
    public function get($id){
        return $this->menu->find($id);
    }

    /**
     * Get all menu by language
     * @param null $lang
     * @return mixed
     */
    public function getWithLang($lang = null){
        if(isset($lang))
            return $this->menu->where('lang', $lang)->get();
        else
            return $this->menu->get();
    }

    /**
     * Get all menu
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Menu[]
     */
    public function all(){
        return $this->menu->with('membergroup')->get();
    }

    /**
     * Create a menu
     * @param $inputs array The form inputs
     * @return Menu The new menu
     */
    public function create($inputs){
        $menu = new Menu();
        $menu->name = $inputs['name'];
        $menu->isEnabled = true;
        $menu->isMain = $inputs['isMain'];
        $menu->fkMemberGroup = $inputs['membergroup'];
        $menu->lang = $inputs['lang'];
        $menu->save();
        return $menu;
    }

    /**
     * Update a menu
     * @param $menu Menu The menu
     * @param $inputs array The form inputs
     * @return Menu The updated menu
     */
    public function update($menu, $inputs){
        $menu->name = $inputs['name'];
        $menu->description = $inputs['description'];
        $menu->json = $inputs['json'];
        $menu->isMain = $inputs['isMain'];
        $menu->fkMemberGroup = $inputs['membergroup'];
        if(isset($inputs['lang']))
            $menu->lang = $inputs['lang'];

        $menu->save();
        return $menu;
    }

    /**
     * Delete a menu by id
     * @param $id int The id
     * @return int
     */
    public function delete($id){
        return $this->menu->destroy($id);
    }


    /**
     * Get a menu menu by membergourp
     * @param $idMemberGroup int The if of the membergroup
     * @return mixed Menu|null
     */
    public function getMenuMainByMemberGroup($idMemberGroup){

        return $this->menu
            ->where('isEnabled', 1)
            ->where('fkMemberGroup', $idMemberGroup)
            ->where('isMain', 1)
            ->first();
    }

    /**
     * Get a main menu by membergroup and language
     * @param $idMemberGroup int The id of a membergroup
     * @param $lang string The lang
     * @return mixed Menu|null
     */
    public function getMenuMainByMemberGroupAndLang($idMemberGroup, $lang){
        return $this->menu
            ->where('isEnabled', 1)
            ->where('fkMemberGroup', $idMemberGroup)
            ->where('isMain', 1)
            ->where('lang', $lang)
            ->first();
    }

    /**
     * Update page name in menu json for the corresponding lang
     * @param $newTitle string The new name
     * @param $lang string|null The lang slug
     * @param $page Page The page
     * @return bool True if success
     */
    public function updateNameInCustomMenu($newTitle, $lang, $page) {

        if($page->name != $newTitle) {
            if(om_config('om_enable_front_langauge')){
                if(!isset($lang)){
                    // if no lang defined for the page then there will be no corresponding menu. So we do nothing.
                    return true;
                }
                $menus = $this->getAllWhereJsonLikeAndLang($page->name, $lang);
            }
            else{
                $menus = $this->getAllWhereJsonLike($page->name);
            }

            foreach ($menus as $menu) {
                $oldKey = '"title":"'.$page->name.'"';
                $newKey = '"title":"'.$newTitle.'"';
                $menu->json = str_replace($oldKey, $newKey, $menu->json);
                $success = $menu->save();
                if(!$success) return false;
            }
        }
        return true;
    }

    /**
     * Update page slug in menu json for the corresponding lang
     * @param $newAlias string The new slug
     * @param $lang string|null The lang slug
     * @param $page Page The page
     * @return bool True if success
     */
    public function updateSlugInCustomMenu($newAlias, $lang, $page) {

        if($page->slug != $newAlias) {
            if(om_config('om_enable_front_langauge')){
                if(!isset($lang)){
                    // if no lang defined for the page then there will be no corresponding menu. So we do nothing.
                    return true;
                }
                $menus = $this->getAllWhereJsonLikeAndLang($page->slug, $lang);
            }
            else{
                $menus = $this->getAllWhereJsonLike($page->slug);
            }

            foreach ($menus as $menu) {
                $oldKey = '"url":"'.$page->slug.'"';
                $newKey = '"url":"'.$newAlias.'"';
                $menu->json = str_replace($oldKey, $newKey, $menu->json);
                $success = $menu->save();
                if(!$success) return false;
            }
        }
        return true;
    }


    /**
     * Get all menus that contains the given string in his json
     * @param $clause string
     * @return mixed Menu[]
     */
    private function getAllWhereJsonLike($clause){
        $clause = '%'.$clause.'%';
        return $this->menu->where('json', 'like', $clause)->get();
    }

    /**
     * Get all menus that contains the given string in his json and that is in the given language
     * @param $clause string
     * @param $lang string
     * @return mixed Menu[]
     */
    private function getAllWhereJsonLikeAndLang($clause, $lang){
        $clause = '%'.$clause.'%';
        return $this->menu->where('json', 'like', $clause)->where('lang', $lang)->get();
    }

}