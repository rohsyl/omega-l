<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 18.09.18
 * Time: 12:59
 */

namespace Omega\Repositories;

use Omega\Models\Menu;

class MenuRepository
{
    private $menu;

    public function __construct(Menu $menu) {
        $this->menu = $menu;
    }

    public function get($id){
        return $this->menu->find($id);
    }

    public function getWithLang($lang = null){
        if(isset($lang))
            return $this->menu->where('lang', $lang)->get();
        else
            return $this->menu->get();
    }

    public function all(){
        return $this->menu->with('membergroup')->get();
    }

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

    public function delete($id){
        return $this->menu->destroy($id);
    }




    public function getMenuMainByMemberGroup($idMemberGroup){

        return $this->menu
            ->where('isEnabled', 1)
            ->where('fkMemberGroup', $idMemberGroup)
            ->where('isMain', 1)
            ->first();
    }

    public function getMenuMainByMemberGroupAndLang($idMemberGroup, $lang){
        return $this->menu
            ->where('isEnabled', 1)
            ->where('fkMemberGroup', $idMemberGroup)
            ->where('isMain', 1)
            ->where('lang', $lang)
            ->first();
    }

    public function updateNameInCustomMenu($newTitle, $page) {

        if($page->name != $newTitle) {
            $menus = $this->getAllWhereJsonLike($page->name);
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

    public function updateSlugInCustomMenu($newAlias, $page) {

        if($page->slug != $newAlias) {
            $menus = $this->getAllWhereJsonLike($page->slug);

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


    private function getAllWhereJsonLike($clause){
        $clause = '%'.$clause.'%';
        return $this->menu->where('json', 'like', $clause)->get();
    }

}