<?php
use Omega\Utils\Renderable\PageRenderer;

if(!function_exists('page')){

    /**
     * Return a page renderer
     * @return PageRenderer
     */
    function page(){
        return new PageRenderer();
    }
}
