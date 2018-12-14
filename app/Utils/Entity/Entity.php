<?php
namespace Omega\Utils\Entity;

use Omega\Models\Lang;
use Omega\Library\Util\Omega;

class Entity{

    /**
     * @var Page
     */
    private $page;

    /**
     * @var Menu
     */
    private $menu;

    /**
     * @var Site
     */
    private $site;

    /**
     * @var Lang
     */
    private $lang;

    /**
     * @var string
     */
    private $langSlug = null;

    /**
     * @param $page Page
     */
    public function setPage($page){
        $this->page = $page;
    }

    /**
     * @param $menu Menu
     */
    public function setMenu($menu){
        $this->menu = $menu;
    }

    /**
     * @param $site Site
     */
    public function setSite($site){
        $this->site = $site;
    }

    /**
     * @param $lang Lang
     */
    public function setLang($lang){
        $this->lang = $lang;
    }

    public function setLangSlug($langSlug){
        $this->langSlug = $langSlug;
    }

    /**
     * @return Menu
     */
    public function Menu(){
        return $this->menu;
    }

    /**
     * @return Page
     */
    public function Page(){
        return $this->page;
    }

    /**
     * @return Site
     */
    public function Site(){
        return $this->site;
    }

    /**
     * @return Lang
     */
    public function Lang(){
        return $this->lang;
    }

    /**
     * @return null|string
     */
    public function LangSlug(){

        return $this->langSlug;
    }
}