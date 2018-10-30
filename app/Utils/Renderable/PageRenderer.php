<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 30.10.2018
 * Time: 22:24
 */

namespace Omega\Utils\Renderable;


use Illuminate\Contracts\Support\Renderable;
use Omega\Models\Lang;
use Omega\Models\Theme;
use Omega\Repositories\LangRepository;
use Omega\Repositories\ThemeRepository;
use Omega\Utils\Entity\Entity;
use Omega\Utils\Entity\Menu;
use Omega\Utils\Entity\Page;
use Omega\Utils\Path;

class PageRenderer implements Renderable
{

    private $id = null;
    private $lang = null;


    private $langRepository;
    private $themeRepository;

    public function __construct() {
        $this->langRepository = new LangRepository(new Lang());
        $this->themeRepository = new ThemeRepository(new Theme());
    }


    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        // if lang not enabled, force lang to null.
        if(!$this->langRepository->isEnabled()) $this->lang = null;


        // if no id set, then we will get the id of the homepage
        if($this->id == null){
            $this->id = Page::GetHome($this->lang);
        }


        return $this->renderById();
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

        if($this->id == '_404') {
            return abord(404);
        }

        Entity::SetPage(new Page($this->id));

        Entity::SetMenu(new Menu());
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

        $indexPath = Path::Combine($themePath, 'index.php');
        $headerPath = Path::Combine($themePath, 'header.php');
        $modelPath = Path::Combine($themePath, 'template', $page->model);

        // we load body and footer before the header so every assets is listed
        // in the Html object and then we can do a render of CSS and JS in the header
        ob_start();
        if(!isset($page->model) || $page->model == 'default' || empty($page->model)) {
            include_once($indexPath);
        }
        else if (file_exists($modelPath)) {
            include_once($modelPath);
        }
        else {
            include_once($indexPath);
        }
        $pageBodyAndFooter = ob_get_clean();

        // load the header and echo the body and footer
        ob_start();
        include_once($headerPath);
        echo $pageBodyAndFooter;
        return ob_get_clean();
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