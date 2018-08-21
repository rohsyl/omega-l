<?php
namespace Omega\Utils\Entity;

use Omega\Library\DTO\Lang;
use Omega\Library\Util\Omega;

class Entity{

    /**
     * @var Page
     */
    private static $page;

    /**
     * @var Menu
     */
    private static $menu;

    /**
     * @var Omega
     */
    private static $site;

    /**
     * @var Lang
     */
    private static $lang;

    /**
     * @param $page Page
     */
    public static function SetPage($page){
        self::$page = $page;
    }

    /**
     * @param $menu Menu
     */
    public static function SetMenu($menu){
        self::$menu = $menu;
    }

    /**
     * @param $site Omega
     */
    public static function SetSite($site){
        self::$site = $site;
    }

    /**
     * @param $lang Lang
     */
    public static function SetLang($lang){
        self::$lang = $lang;
    }

    /**
     * @return Menu
     */
    public static function Menu(){
        return self::$menu;
    }

    /**
     * @return Page
     */
    public static function Page(){
        return self::$page;
    }

    /**
     * @return Omega
     */
    public static function Site(){
        return self::$site;
    }

    /**
     * @return Lang
     */
    public static function Lang(){
        return self::$lang;
    }

    /**
     * @return null|string
     */
    public static function LangSlug(){

        if(self::Lang() !== null){
            return self::Lang()->slug;
        }
        return null;
    }
}