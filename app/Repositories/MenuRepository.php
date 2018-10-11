<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 18.09.18
 * Time: 12:59
 */

namespace Omega\Repositories;

use Omega\Menu;

class MenuRepository
{
    private $menu;

    public function __construct(Menu $menu) {
        $this->menu = $menu;
    }

    public function get($id){
        return $this->menu->find($id);
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
}