<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 13.11.18
 * Time: 11:36
 */

namespace Omega\Utils\Renderable;


use Illuminate\Contracts\Support\Renderable;

class PageRenderable implements Renderable
{
    private $content;

    public function __construct($content){
        $this->content = $content;
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render() {
        return $this->content;
    }
}