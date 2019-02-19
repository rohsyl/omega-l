<?php
namespace OmegaPlugin\MultilanguePageReplicate;

use Illuminate\Support\Facades\Validator;
use Omega\Models\Lang;
use Omega\Models\Page;
use Omega\Models\PageLangRel;
use Omega\Repositories\LangRepository;
use Omega\Repositories\PageLangRelRepository;
use Omega\Repositories\PageRepository;
use Omega\Utils\Plugin\BController;
use Omega\Utils\Plugin\Type;

class BControllerMultilanguePageReplicate extends  BController {

    private $pageRepository;
    private $langRepository;
    private $pageLangRelRepository;

    public function __construct() {
        parent::__construct('multilangue_page_replicate');

        $this->pageRepository = new PageRepository(new Page());
        $this->langRepository = new LangRepository(new Lang());
        $this->pageLangRelRepository = new PageLangRelRepository(new PageLangRel());
    }

    public function index() {

        $langs = $this->langRepository->allEnabled();



        return $this->view('index')->with([
            'langs' => $langs,
            'langselect' => to_select($langs, 'name', 'slug', ['null' => __('Choose a language')]),
        ]);
    }

    public function save(){

        $request = request();
        $validator = Validator::make($request->all(), array_merge(['title' => self::RULE_TITLE], $this->getValidationRules()));

        if ($validator->fails()) {
            return $this->redirect('index')
                ->withErrors($validator)
                ->withInput();
        }

        $module = $this->moduleRepository->getByName($this->moduleName);
        $param = isset($module) ? json_decode($module->param, true) : array();

        foreach ($this->socialNetwork as $key => $sn) {
            if($request->has($key)){
                $param[$key] = $request->input($key);
            }
        }
        $param['title'] = $request->input('title');
        $this->moduleRepository->saveParam($module, $param);

        toast()->success(__('Saved'));
        return $this->redirect('index');
    }

    private function getValidationRules(){
        $rules = [];
        foreach ($this->socialNetwork as $key => $sn) {
            $rules[$key] = self::RULE;
        }
        return $rules;
    }



    public function pageList(){

        $request = request();

        $lang = $request->get('lang');
        $pages = $this->pageRepository->getPageWithParentAndLang($lang, null);

        return response()->json([
            'pages' => $pages,
        ]);
    }

    public function langList(){

        $request = request();

        $lang = $request->get('lang');

        $langs = $this->langRepository->allEnabledExcept($lang);

        return response()->json([
            'langs' => $langs,
        ]);
    }

    public function duplicate(){
        $request = request();

        $pages = $request->input('pages');
        $langs = $request->input('langs');
        $duplicate_components = $request->input('duplicate_components');
        $duplicate_modules = $request->input('duplicate_modules');
        $duplicate_pagechild = $request->input('duplicate_pagechild');

        foreach($langs as $lang){
            foreach($pages as $pageId){

                $page = $this->pageRepository->get($pageId);
                $this->duplicatePage($page, $lang, $duplicate_components, $duplicate_modules, $duplicate_pagechild);
            }
        }

        return response()->json([
            'success' => true
        ]);

    }

    /**
     * @param $page Page
     * @param $lang
     * @param $duplicate_components
     * @param $duplicate_modules
     * @param $duplicate_pagechild
     * @param int $level
     */
    private function duplicatePage($page, $lang, $duplicate_components, $duplicate_modules, $duplicate_pagechild, $level = 0, $idParent = null){

        $newPage = $page->replicate();
        $newPage->lang = $lang;
        $newPage->slug = $page->slug;
        if(isset($idParent)){
            $newPage->fkPageParent = $idParent;
        }
        $newPage->save();

        $this->pageLangRelRepository->savePageLangRel($page->id, $newPage->id, $lang);

        if($duplicate_components)
        {
            foreach($page->components as $component){
                $newComponent = $component->replicate();
                $newComponent->fkPage = $newPage->id;
                $newComponent->name = $component->name;
                $newComponent->save();

                Type::DuplicateValues($component->id, $newComponent->id);
            }
        }

        if($duplicate_modules){
            foreach($page->modulesonly as $component){
                $newComponent = $component->replicate();
                $newComponent->fkPage = $newPage->id;
                $newComponent->name = $component->name;
                $newComponent->save();

                Type::DuplicateValues($component->id, $newComponent->id);
            }
        }

        if($duplicate_pagechild && $level < 1){
            $children = $page->children;
            if(sizeof($children) > 0){
                foreach($children as $child){
                    $this->duplicatePage($child, $lang, $duplicate_components, $duplicate_modules, false, ++$level, $newPage->id);
                }
            }
        }
    }
}