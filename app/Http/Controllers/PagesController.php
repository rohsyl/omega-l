<?php

namespace Omega\Http\Controllers;

use Illuminate\Validation\Rule;
use Omega\Http\Requests\Page\Component\SaveSettingsRequest;
use Omega\Http\Requests\Page\Module\CreateModuleRequest;
use Omega\Http\Requests\Page\SortRequest;
use Omega\Repositories\MembergroupRepository;
use Omega\Repositories\PageLangRelRepository;
use Omega\Repositories\PageSecurityRepository;
use Omega\Repositories\PageSecurityTypeRepository;
use Omega\Repositories\PluginRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Omega\Http\Requests\Page\CreatePageRequest;
use Omega\Http\Requests\Page\UpdateRequest;
use Omega\Repositories\LangRepository;
use Omega\Repositories\MenuRepository;
use Omega\Repositories\ModuleAreaRepository;
use Omega\Repositories\ModuleRepository;
use Omega\Repositories\PageRepository;
use Omega\Repositories\PositionRepository;
use Omega\Repositories\ThemeRepository;
use Omega\Utils\Plugin\PluginMeta;
use Omega\Utils\Plugin\Type;
use Omega\Utils\Entity\Page as PageHelper;

/**
 * Class PagesController.
 * Manage pages.
 * @package Omega\Http\Controllers
 */
class PagesController extends AdminController
{

    private $langRepository;
    private $pageRepository;
    private $pageLangRelRepository;
    private $pageSecurityTypeRepository;
    private $pageSecurityRepository;
    private $moduleAreaRepository;
    private $themeRepository;
    private $positionRepository;
    private $moduleRepository;
    private $menuRepository;
    private $membergroupRepository;
    private $pluginRepository;

    public function __construct(LangRepository $langRepository,
                                PageRepository $pageRepository,
                                PageLangRelRepository $pageLangRelRepository,
                                PageSecurityRepository $pageSecurityRepository,
                                PageSecurityTypeRepository $pageSecurityTypeRepository,
                                ModuleAreaRepository $moduleAreaRepository,
                                ThemeRepository $themeRepository,
                                PositionRepository $positionRepository,
                                ModuleRepository $moduleRepository,
                                MenuRepository $menuRepository,
                                MembergroupRepository $membergroupRepository,
                                PluginRepository $pluginRepository)
    {
        parent::__construct();

        $this->langRepository = $langRepository;
        $this->pageRepository = $pageRepository;
        $this->pageLangRelRepository = $pageLangRelRepository;
        $this->pageSecurityRepository = $pageSecurityRepository;
        $this->pageSecurityTypeRepository = $pageSecurityTypeRepository;
        $this->moduleAreaRepository = $moduleAreaRepository;
        $this->themeRepository = $themeRepository;
        $this->positionRepository = $positionRepository;
        $this->moduleRepository = $moduleRepository;
        $this->menuRepository = $menuRepository;
        $this->membergroupRepository = $membergroupRepository;
        $this->pluginRepository = $pluginRepository;
    }

    /**
     * The list of pages
     * @param null $lang If not null, filter by lang
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($lang = null){


        $enabledLang = om_config('om_enable_front_langauge');
        $defaultLang = om_config('om_default_front_langauge');

        $currentLang = null;
        if($enabledLang){
            $currentLang = isset($lang) ? $lang : null;

            if(!isset($currentLang) && session()->has('backoffice_lang_pages')){
                $currentLang = session('backoffice_lang_pages');
            }
        }

        $viewBag = [
            'enabledLang' => $enabledLang,
            'defaultLang' => $defaultLang,
            'currentLang' => $currentLang,
            'langs' => to_select($this->langRepository->allEnabled(), 'name', 'slug', [null => __('None')]),
        ];
        return view('pages.index')->with($viewBag);
    }

    /**
     * Change the selected lang
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function chooseLang(Request $request){
        session(['backoffice_lang_pages' => $request->input('lang')]);
        return redirect()->route('admin.pages', ['lang' => $request->input('lang')]);
    }

    /**
     * Display the form to add a new page
     * @param null $lang If not null, set by default the given lang
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add($lang = null){
        $enabledLang = om_config('om_enable_front_langauge');

        $langs = $this->langRepository->allEnabled();

        $pages = !$enabledLang
            ? $this->pageRepository->getPageWithParentAndLang(null, null)
            : $this->pageRepository->getPageWithParentAndLang($lang, null);

        return view('pages.add')->with([
            'enableLang' => $enabledLang,
            'selectedLang' => $lang,
            'langs' => to_select($langs, 'name', 'slug', [null => __('None')]),
            'pages' => to_select($pages, 'name', 'id', [null => __('No parent')]),
        ]);
    }

    public function getPagesLevelZeroBylang($lang = null){

        $pages = !isset($lang)
            ? $this->pageRepository->getPageWithParentAndLang(null, null)
            : $this->pageRepository->getPageWithParentAndLang($lang, null);

        return view('pages.pages_select_options')->with([
            'pages' => $pages
        ]);
    }

    /**
     * Create a new page
     * @param CreatePageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(CreatePageRequest $request){
        $inputs = $request->all();
        $this->pageRepository->create($inputs);

        $args = [];
        if(isset($inputs['lang']))
            $args['lang'] = $inputs['lang'];

        return redirect()->route('admin.pages', $args);
    }

    /**
     * Display the form to edit a page
     * @param $id int The id of the page
     * @param string $tab The selected tab
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, $tab = 'content'){

        $enabledLang = om_config('om_enable_front_langauge');
        $currentTheme = $this->themeRepository->getCurrentThemeName();
        $page = $this->pageRepository->get($id);
        $langs = $this->langRepository->allEnabled();

        // Get the security type of the page
        $security = $page->security;
        if($security != null) {
            $securityType = $page->security->type;
        }
        // If not defined, set it to NoneSecurity
        else {
            $securityType = $this->pageSecurityTypeRepository->getSecurityNone();
            $security = $this->pageSecurityRepository->newInstanceOfType($securityType, $page->id);
        }


        return view('pages.edit')->with([
            'tab' => isset($tab) ? $tab : 'content',
            'enabledLang' => $enabledLang,
            'page' => $page,

            'pages' => remove_by_key(to_select($this->pageRepository->getPagesWithParent(null), 'name', 'id', [null => __('No parent')]), $page->id),
            'models' => array_to_select($this->themeRepository->getThemeTemplate($currentTheme), ['default' => __('Default model')]),
            'menus' => to_select($this->menuRepository->getWithLang($enabledLang ? $page->lang : null), 'name','id', [null => __('Default menu')]),
            'cssThemes' => array_to_select($this->themeRepository->getThemeCssThemes($currentTheme), ['none' => __('None')]),

            'langs_select' => to_select($langs, 'name', 'slug', [null => __('None')]),
            'langs' => $langs,
            'correspondingParents' => $this->pageRepository->getCorrespondingParents($langs, $page),

            'securityType' => $securityType->name,
            'securityData' => unserialize($security->data),

            'groups' => to_select($this->membergroupRepository->all(), 'name', 'id')
        ]);
    }

    /**
     * Get all modulearea for the given page
     * @param $pageId int The id of the page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function moduleareaList($pageId) {
        $moduleAreas = $this->moduleAreaRepository->getAllModuleAreaByThemeName($this->themeRepository->getCurrentThemeName());
        return view('pages.modulearealist')->with([
            'moduleAreas' => $moduleAreas,
            'pageId' => $pageId
        ]);
    }

    /**
     * Get all component for the given page
     * @param $pageId int The id of the page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function componentList($pageId){
        $cs = $this->moduleRepository->getAllComponentsByPage($pageId);
        $components = array();

        foreach ($cs as $c) {
            $item['id'] = $c->id;
            $item['pluginMeta'] = new PluginMeta($c->plugin->name);
            $item['html'] = Type::FormRender($c->fkPlugin, $c->id, $pageId);
            $item['args'] = json_decode($c->param, true);
            $components[] = $item;
        }

        return view('pages.componentlist')->with([
            'components' => $components
        ]);
    }

    /**
     * Get all modules for the given page
     * @param $pageId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function moduleList($pageId){
        $modules = $this->moduleRepository->getAllModulesByPage($pageId);

        return view('pages.modulelist')->with([
            'modules' => $modules
        ]);
    }

    /**
     * Update the given page
     * @param UpdateRequest $request
     * @param $id int The id of the page
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, $id){

        $enabledLang = om_config('om_enable_front_langauge');


        $lang = null;
        if(om_config('om_enable_front_langauge')){
            $lang = real_null($request->input('lang'));
        }

        // TODO : unique slug
        // make sur the slug is unique
        /*
        $validator = Validator::make($request->all(), [
            'slug' => [
                Rule::unique('pages')->ignore($id)->where('lang', $lang)
                Rule::unique('pages')->where(function ($query) use($page) {
                    return $query->where('lang', $page->lang);
                })->ignore($id),
                //Rule::unique('pages')->ignore($id),
            ],
        ]);
        // send back with errors if the validation fails
        if ($validator->fails()) {
            toast()->error(__('Errors while saving the page'));
            return redirect()
                ->route('admin.pages.edit', ['id' => $id, 'tab' => $request->input('tab')])
                ->withErrors($validator)
                ->withInput();
        }*/


        $page = $this->pageRepository->get($id);


        // clear lang relation if the lang of the page is changed
        if($enabledLang){
            $this->pageLangRelRepository->clearRelIfLangChanged($page, $request->all());
        }

        $mr = $this->menuRepository;

        // update the page basic data
        // update the name and slug in all menus
        $this->pageRepository->update($page, $request->all(), function($name, $slug, $lang, $page) use ($mr) {
            $mr->updateNameInCustomMenu($name, $lang, $page);
            $mr->updateSlugInCustomMenu($slug, $lang, $page);
        });

        // save the page relations
        if($enabledLang){
            if($request->has('plangs_rel')){
                $langs_page_rel = $request->input('plangs_rel');
                foreach($langs_page_rel as $lang => $rel){
                    if($lang != $page->lang)
                        $this->pageLangRelRepository->savePageLangRel($id, real_null($rel), $lang);
                }
            }
        }

        // save the security settings
        switch ($request->input('security'))
        {
            // secure the page with a password
            case 'bypassword':
                $this->pageSecurityRepository->update(
                    $page->security,
                    $this->pageSecurityTypeRepository->getSecurityPassword(),
                    [
                        'message' => $request->input('security_message'),
                        'password' => $request->input('security_password')
                    ]
                );
                break;
            // secure the page by membergroup
            // only the authenticated member that are in the selected group can see this page
            case 'bymember':
                $this->pageSecurityRepository->update(
                    $page->security,
                    $this->pageSecurityTypeRepository->getSecurityMember(),
                    [
                        'membergroup' => $request->input('security_membergroup')
                    ]
                );
                break;
            // no security
            // this page is public
            case 'none' :
            default :
                $this->pageSecurityRepository->update(
                    $page->security,
                    $this->pageSecurityTypeRepository->getSecurityNone()
                );
                break;
        }


        // Save all component fields
        $cs = $this->moduleRepository->getAllComponentsByPage($id);
        foreach($cs as $c) {
            Type::FormSave($c->fkPlugin, $c->id, $id);
        }

        toast()->success(__('Page saved'));
        return redirect()->route('admin.pages.edit', ['id' => $page->id, 'tab' => $request->input('tab')]);
    }

    /**
     * Soft-Delete a page by id after confirmation
     * @param $id int The id of the page
     * @param bool $confirm
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function delete($id, $confirm = false){
        if($confirm){
            $this->pageRepository->delete($id);
            toast()->success(__('Page deleted'));
            return redirect()->route('admin.pages');
        }
        else{
            return view('pages.delete')
                ->with(['id' => $id]);
        }
    }

    /**
     * Enable or disable the given page
     * @param $id int The id of the page
     * @param $enable boolean
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enable($id, $enable){
        $page = $this->pageRepository->get($id);
        $this->pageRepository->enable($page, $enable);
        toast()->success($enable ? __('Page enabled') : __('Page disabled'));
        return redirect()->back();
    }


    public function sort(SortRequest $request){
        $orders = $request->input('order');
        foreach($orders as $p)
        {
            $page = $this->pageRepository->get($p['id']);
            $page->order = $p['order'];
            $result = $page->save();
            if(!$result)
                break;
        }
        return response()->json([
            'result' => $result,
        ]);
    }

    /**
     * Get the table with all the page filtered by lang
     * @param null|string $lang
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTable($lang = null){
        $enabledLang = om_config('om_enable_front_langauge');

        $pages = !$enabledLang ?
            $this->pageRepository->paginatePagesWithParent(null) :
            $this->pageRepository->paginatePageWithParentAndLang($lang, null);

        $pages->withPath(route('admin.pages'));

        return view('pages.indextable')->with([
            'enabledLang' => $enabledLang,
            'currentLang' => $lang,
            'pages' => $pages,
        ]);
    }

    /**
     * Get all pages filtered by parent and lang
     * Used for the multi-lang
     * @param $pid int The id of the current page
     * @param $lang string The selected lang
     * @param null $idParent The id of the page parent
     * @return \Illuminate\Http\JsonResponse
     */
    function getAllPageByParentAndLang($pid, $lang, $idParent = null){
        return response()->json([
            'selected' => PageHelper::GetCorrespondingInLang($pid, $lang),
            'pages' => $this->pageRepository->getPageWithParentAndLang($lang, $idParent)
        ]);
    }


    #region component
    /**
     * Get the form to create a component
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreateFormForComponent(){
        return view('pages.component.create')->with([
            'plugins' => $this->pluginRepository->getPluginsWithComponentsSupport()
        ]);
    }

    /**
     * Get the form to edit a component
     * @param $id int The id of the component
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getComponentForm($id){
        $comp = $this->moduleRepository->get($id);
        $item = array(
            'id' => $comp->id,
            'pluginMeta' => new PluginMeta($comp->plugin->name),
            'html' => Type::FormRender($comp->fkPlugin, $id, $comp->fkPage),
            'args' => json_decode($comp->param, true)
        );
        $components[] = $item;

        return view('pages.componentlist')->with([
            'components' => $components
        ]);
    }

    /**
     * Create a component
     * @param $pageId int The id of the page on which the component must be created
     * @param $pluginId int The id of the plugin
     * @return \Illuminate\Http\JsonResponse
     */
    function createComponent($pageId, $pluginId) {
        $plugin = $this->pluginRepository->get($pluginId);
        $comp = $this->moduleRepository->createComponent($pageId, $plugin);
        return response()->json([
            'result'  => $comp->id
        ]);
    }

    /**
     * Delete a component
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    function deleteComponent($id) {
        $result = $this->moduleRepository->delete($id);
        return response()->json([
            'result'  => $result
        ]);
    }

    /**
     * Get a form to manage the settings of a component
     * @param $compId int The id of the component
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFormComponentSettings($compId) {

        $module = $this->moduleRepository->get($compId);

        // TODO : improve the managment of the settings
        // using a Form ? (class:Type)

        $themeName = $this->themeRepository->getCurrentThemeName();
        $pluginName = $module->plugin->name;

        $componentsTemplates = $this->pluginRepository->getPluginTemplateViewsByTheme($themeName, $pluginName);

        $pluginTemplatesWithTitle = array();
        $pluginTemplatesWithTitle['null'] = __('Default');
        foreach($componentsTemplates as $views){
            foreach($views as $newView){
                $newViewName = $newView->getNewViewPath();
                $label = $newView->getLabel();
                if(!isset($label)){
                    $label = prettify_text($themeName) . ' - ' . prettify_text($pluginName) . ' - ' . without_ext(without_ext(prettify_text($newViewName)));
                }
                $pluginTemplatesWithTitle[theme_encode_components_template($themeName, $newView)] = $label;
            }
        }

        $themeColors = $this->themeRepository->getThemeColors($themeName);
        $viewBag = [];
        $args = json_decode($module->param, true);
        if(isset($args['settings']['isWrapped'])) {
            $viewBag['isWrapped'] = $args['settings']['isWrapped'];
        }
        else {
            $viewBag['isWrapped'] = true;
        }
        if(isset($args['settings']['bgColorType'])) {
            $viewBag['bgColorType'] = $args['settings']['bgColorType'];
        }
        else {
            $viewBag['bgColorType'] = 'transparent';
        }
        if(isset($args['settings']['bgColor'])) {
            $viewBag['bgColor'] = $args['settings']['bgColor'];
        }
        else {
            $viewBag['bgColor'] = 'transparent';
        }
        if(isset($args['settings']['isHidden'])) {
            $viewBag['isHidden'] = $args['settings']['isHidden'];
        }
        else {
            $viewBag['isHidden'] = false;
        }
        if(isset($args['settings']['compId'])) {
            $viewBag['compId'] = $args['settings']['compId'];
        }
        else {
            $viewBag['compId'] = '';
        }
        if(isset($args['settings']['pluginTemplate'])){
            $viewBag['pluginTemplate'] = $args['settings']['pluginTemplate'];
            $viewBag['isPluginTemplateUpToDate'] = $this->pluginRepository->isPluginTemplateUpToDate($viewBag['pluginTemplate']);
        }
        else{
            $viewBag['pluginTemplate'] = 'null';
            $viewBag['isPluginTemplateUpToDate'] = null;
        }
        if(isset($args['settings']['compTitle'])){
            $viewBag['compTitle'] = $args['settings']['compTitle'];
        }
        else{
            $viewBag['compTitle'] = '';
        }



        $viewBag['pluginTemplates'] = $pluginTemplatesWithTitle;
        $viewBag['themeColors'] = $themeColors;
        return view('pages.component.settings')->with($viewBag);
    }

    public function isComponentsTemplateUpToDate(Request $request){
        $bol = $this->pluginRepository->isPluginTemplateUpToDate($request->post('componentsTemplateString'));
        return response()->json([
            'upToDate' => $bol
        ]);
    }

    /**
     * Save settings of a component
     * @param SaveSettingsRequest $request
     * @param $compId int The id of the component
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveSettings(SaveSettingsRequest $request, $compId) {
        $module = $this->moduleRepository->get($compId);
        $args = json_decode($module->param, true);
        if(!isset($args['settings'])) $args['settings'] = array();
        $args['settings']['compId'] = $request->input('compId');
        $args['settings']['compTitle'] = $request->input('compTitle');
        $args['settings']['isHidden'] = intval($request->input('is_hidden'));
        $args['settings']['isWrapped'] = $request->input('comp_width') == 'wrapped';
        switch($_POST['bgcolor']) {
            case 'custom':
                $args['settings']['bgColor'] = $request->input('customcolor');
                $args['settings']['bgColorType'] = 'custom';
                break;
            case 'theme':
                $args['settings']['bgColor'] = $request->input('themecolor');
                $args['settings']['bgColorType'] = 'theme';
                break;
            default:
                $args['settings']['bgColor'] = 'transparent';
                $args['settings']['bgColorType'] = 'transparent';
                break;
        }
        $args['settings']['pluginTemplate'] = $request->input('compTemplate');
        $this->moduleRepository->saveParam($module, $args);

        return response()->json([
            'args' => $args,
            'result'  => true
        ]);


    }

    /**
     * Change the order of a component
     * @param $compId int The id of the component
     * @param $position string The way of moving the component (upper, up, downer, down)
     * @return \Illuminate\Http\JsonResponse
     */
    public function orderComponent($compId, $position){
        $module = $this->moduleRepository->get($compId);
        $pageId = $module->fkPage;

        $this->moduleRepository->componentOrderInitForPage($pageId);
        switch($position){
            case 'upper':
                $this->moduleRepository->componentOrderSetOrderUpper($compId, $pageId);
                break;
            case 'up':
                $this->moduleRepository->componentOrderSetOrderUp($compId, $pageId);
                break;
            case 'downer':
                $this->moduleRepository->componentOrderSetOrderDowner($compId, $pageId);
                break;
            case 'down':
                $this->moduleRepository->componentOrderSetOrderDown($compId, $pageId);
                break;
        }
        return response()->json([
            'result'  => true
        ]);
    }
    #endregion


    #region module
    /**
     * Get the form to create a module
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreateFormForModule(){
        return view('pages.module.create')->with([
            'plugins' => to_select($this->pluginRepository->getPluginsWithModulesSupport(), 'name', 'id')
        ]);
    }

    /**
     * Create a module
     * @param CreateModuleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createModule(CreateModuleRequest $request) {
        $this->moduleRepository->create(
            $request->input('pluginId'),
            $request->input('name'),
            [],
            false,
            true,
            $request->input('pageId')
        );
        return response()->json([
            'result'  => true
        ]);
    }

    /**
     * Get a form to edit a module
     * @param $moduleId int The id of the module
     * @param $pageId int The id of the page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function getEditFormForModule($moduleId, $pageId) {
        $module = $this->moduleRepository->get($moduleId);
        $pluginId = $module->fkPlugin;
        return Type::FormRender($pluginId, $moduleId, $pageId);
    }

    /**
     * Save the module
     * @param $moduleId The id of the module
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveModule($moduleId) {
        $module = $this->moduleRepository->get($moduleId);
        $res = Type::FormSave($module->fkPlugin, $moduleId, $module->fkPage);
        return response()->json([
            'result'  => $res
        ]);
    }
    #endregion




    public function trash(){
        return view('pages.trash')->with([
            'pages' => $this->pageRepository->deleted_paginate(),
        ]);
    }

    public function restore($id){
        $this->pageRepository->restore($id);

        toast()->success(__('Page restored succesfully!'));
        return redirect()->route('admin.pages.edit', ['id' => $id]);
    }

    public function forcedelete($id){
        $this->pageRepository->forcedelete($id);

        toast()->success(__('Page deleted permanently!'));
        return redirect()->route('admin.pages.trash');
    }
}
