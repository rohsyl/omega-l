<?php

namespace Omega\Http\Controllers;

use Illuminate\Http\Request;
use Omega\Repositories\LangRepository;

class PagesController extends AdminController
{

    private $langRepository;

    public function __construct(LangRepository $langRepository)
    {
        $this->langRepository = $langRepository;
    }

    public function index($lang = null){


        $enabledLang = om_config('om_enable_front_langauge');
        $defaultLang = om_config('om_default_front_langauge');

        $currentLang = null;
        if($enabledLang){
            $currentLang = isset($lang) ? $lang : $defaultLang;
        }

        $viewBag = [
            'enabledLang' => $enabledLang,
            'defaultLang' => $defaultLang,
            'currentLang' => $currentLang,
            'langs' => $this->langRepository->allEnabledForSelect(),
        ];
        return view('pages.index')->with($viewBag);
    }

    public function chooseLang($lang){
        return redirect()->route('admin.pages', ['lang' => $lang]);
    }

    public function add($lang = null){

    }

    public function getTable(){
        $enabledLang = om_config('om_enable_front_langauge');
        $defaultLang = om_config('om_default_front_langauge');
        $currentLang = isset($_GET['lang']) ? $_GET['lang'] : $defaultLang;

        /*
        $pages = !$enabledLang ? PageManager::GetAllPagesWithParent(null) : PageManager::GetAllPagesWithLangs($currentLang, null);
        foreach($pages as $page){
            if(PageManager::CountChild($page->id)){
                $page->children = PageManager::GetAllPagesWithParent($page->id);
                foreach($page->children as $child){
                    $child->owner = UserManager::GetUser($child->fkUser);
                }
            }
            $page->owner = UserManager::GetUser($page->fkUser);
        }*/

        $viewBag = [
            'enabledLang' => $enabledLang,
            'currentLang' => $currentLang,
            'pages' => [],
        ];
        return view('pages.indextable')->with($viewBag);
    }
}
