<?php
namespace OmegaPlugin\LangRedirect;

use Omega\Utils\Entity\Page;
use Omega\Repositories\PageRepository;
use Omega\Utils\Plugin\FController;

class FControllerLangRedirect extends  FController {

    public function __construct() {
        parent::__construct('lang_redirect');
    }

    public function registerDependencies()
    {
        return [
            'css' => [
            ],
            'js' => [

            ]
        ];
    }

    public function display( $args, $data ) {

        $page = null;
        $matches = [];
        $defaultUrl = null;
        $sessionLang = session()->has('front_lang') ? session('front_lang') : null;
        if(isset($data['page']['value'])){
            $pageId = $data['page']['value'];
            $defaultUrl = Page::GetUrl($pageId);

            $page = Page::GetPageRepository()->get($pageId);
            $langs = Page::GetLangRepository()->allEnabled();

            $matches = [];
            foreach($langs as $lang){
                if($lang->slug != $page->slug)
                $matches[$lang->slug] = Page::GetCorrespondingInLang($page->id, $lang->slug);
            }
        }


        foreach($matches as $key => $match){
            if(isset($matches[$key]))
                $matches[$key] = Page::GetUrl($matches[$key]);
        }


        return $this->view('display')->with([
            'page' => $pageId,
            'matches' => $matches,
            'defaultUrl' => $defaultUrl,
            'sessionLang' => $sessionLang
        ]);
    }
}