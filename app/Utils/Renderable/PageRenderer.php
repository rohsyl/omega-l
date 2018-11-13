<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 30.10.2018
 * Time: 22:24
 */

namespace Omega\Utils\Renderable;

use Illuminate\Http\RedirectResponse;
use Omega\Models\Lang;
use Omega\Models\Theme;
use Omega\Repositories\LangRepository;
use Omega\Repositories\ThemeRepository;
use Omega\Facades\Entity;
use Omega\Utils\Entity\Menu;
use Omega\Utils\Entity\Page;
use Omega\Utils\Path;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PageRenderer
{

    private $id = null;
    private $lang = null;
    private $slug = null;


    private $langRepository;
    private $themeRepository;

    public function __construct() {
        $this->langRepository = new LangRepository(new Lang());
        $this->themeRepository = new ThemeRepository(new Theme());
    }


    /**
     * Get the evaluated contents of the object.
     *
     * @return mixed
     */
    public function get()
    {
        // if lang not enabled, force lang to null.
        if(!$this->langRepository->isEnabled()) $this->lang = null;


        // if no id and no slug are set, then we will get the id of the homepage
        if($this->id == null && $this->slug == null){
            $this->id = Page::GetHome($this->lang);
        }


        if(isset($this->slug)){
            $res = Page::GetId($this->slug, $this->lang);

            if($res instanceof RedirectResponse)
                return $res;
            else if($res instanceof HttpException)
                return $res;

            $this->id = $res;
        }


        return $this->renderById();
    }


    public function withSlug($slug){
        $this->slug = $slug;
        return $this;
    }

    public function withId($id){
        $this->id = $id;
        return $this;
    }

    public function withLang($lang){
        $this->lang = $lang;
        return $this;
    }



    /**
     * Render the page with the given id
     * @return mixed The rendered content
     */
    private function renderById(){
        if($this->id == '_404' || $this->id == null) {
            return abort(404);
        }


        Entity::setPage(new Page($this->id));

        Entity::setMenu(new Menu());
        Entity::Menu()->setCurrentPage(Entity::Page());
        $themePath = $this->getThemePath(Entity::Site());

        if( file_exists( $themePath )) {
            if(Entity::Page()->isEnabled) {
                return $this->renderPage($themePath, Entity::Page());
            }
            else {
                return abord(404);
            }
        }
        else {
            return abord(404);
        }
    }


    /**
     * @param $themePath string The path to the theme
     * @param $page Page The page to render
     */
    function renderPage($themePath, $page)
    {
        if($page->exists())
            $page->render();
        else
            $page->content = '404';

        if($page->needRedirect()){
            return $page->getRedirect();
        }

        $modelPath = Path::Combine($themePath, 'template', $page->model);

        // we load body and footer before the header so every assets is listed
        // in the Html object and then we can do a render of CSS and JS in the header
        if(!isset($page->model) || $page->model == 'default' || empty($page->model)) {
            $pageBodyAndFooter = view('theme::index')->render();
        }
        else if (file_exists($modelPath)) {
            $pageBodyAndFooter = view('theme::template.'.without_ext($page->model))->render();
        }
        else {
            $pageBodyAndFooter = view('theme::index')->render();
        }

        // load the header and echo the body and footer
        $pageHeader = view('theme::header')->render();

        return new PageRenderable($pageHeader.$pageBodyAndFooter);
    }


    /**
     * @param $site \Omega\Utils\Entity\Site
     * @return string The path to the theme
     */
    function getThemePath($site)
    {
        global $demoMode;

        $themeName = $site->template_name;
        if(isset($demoMode) && $demoMode)
        {
            $themeName = session()->has('demoTheme') ? session('demoTheme') : $themeName;
        }
        $themePath = theme_path($themeName);
        return $themePath;
    }
}