<?php
use Omega\Utils\Renderable\PageRenderer;
use Omega\Utils\Renderable\ModuleRenderer;

if(!function_exists('page')){

    /**
     * Return a page renderer
     * @return PageRenderer
     */
    function page(){
        return new PageRenderer();
    }
}

if(!function_exists('module')){

    /**
     * Return a page renderer
     * @return ModuleRenderer
     */
    function module(){
        return new ModuleRenderer();
    }
}
