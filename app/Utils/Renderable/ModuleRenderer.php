<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 04.03.19
 * Time: 13:31
 */

namespace Omega\Utils\Renderable;

use Illuminate\Support\ViewErrorBag;
use Illuminate\View\View;
use Omega\Utils\Entity\Page;

class ModuleRenderer
{

    /**
     * @var string
     */
    private $name = null;

    /**
     * @var string
     */
    private $subtitle = null;

    /**
     * @var string
     */
    private $view;

    public function name($name) {
        $this->name = $name;
        return $this;
    }
    public function subtitle($subtitle) {
        $this->subtitle = $subtitle;
        return $this;
    }

    /**
     * @param $view string
     * @return $this
     */
    public function view($view) {
        $this->view = $view;
        return $this;
    }


    /**
     * @return Page
     */
    public function page() {
        $page = new Page();

        if(isset($this->name)) {
            $page->name = $this->name;
        }

        if(isset($this->subtitle)) {
            $page->subtitle = $this->subtitle;
        }

        $page->showName = true;
        $page->showSubtitle = true;

        $page->exists = true;
        $page->setContent(view($this->view)->render());
        $page->setNeedRender(false);
        return $page;
    }
}