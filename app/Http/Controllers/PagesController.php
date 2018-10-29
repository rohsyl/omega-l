<?php

namespace Omega\Http\Controllers;

use Illuminate\Validation\Rule;
use Omega\Http\Requests\Page\Component\SaveSettingsRequest;
use Omega\Http\Requests\Page\Module\CreateModuleRequest;
use Omega\Repositories\GroupRepository;
use Omega\Repositories\MembergroupRepository;
use Omega\Repositories\PageLangRelRepository;
use Omega\Repositories\PageSecurityRepository;
use Omega\Repositories\PageSecurityTypeRepository;
use Omega\Repositories\PluginRepository;
use Validator;
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

    public function index($lang = null){


        $enabledLang = om_config('om_enable_front_langauge');
        $defaultLang = om_config('om_default_front_langauge');

        $currentLang = null;
        if($enabledLang){
            $currentLang = isset($lang) ? $lang : null;
        }

        $viewBag = [
            'enabledLang' => $enabledLang,
            'defaultLang' => $defaultLang,
            'currentLang' => $currentLang,
            'langs' => to_select($this->langRepository->allEnabled(), 'name', 'slug', [null => __('Any')]),
        ];
        return view('pages.index')->with($viewBag);
    }

    public function chooseLang(Request $request){
        return redirect()->route('admin.pages', ['lang' => $request->input('lang')]);
    }

    public function add($lang = null){
        $enabledLang = om_config('om_enable_front_langauge');
        $langs = $this->langRepository->allEnabled();
        $pages = !$enabledLang ? $this->pageRepository->getPagesWithParent(null) : $this->pageRepository->getPageWithParentAndLang($lang, null);

        return view('pages.add')->with([
            'enableLang' => $enabledLang,
            'selectedLang' => $lang,
            'langs' => to_select($langs, 'name', 'slug', [null => __('Any')]),
            'pages' => to_select($pages, 'name', 'id', [null => __('No parent')]),
        ]);
    }

    public function create(CreatePageRequest $request){

        $this->pageRepository->create($request->all());

        return redirect()->route('admin.pages');
    }

    public function edit($id, $tab = 'content'){

        $enabledLang = om_config('om_enable_front_langauge');
        $currentTheme = $this->themeRepository->getCurrentThemeName();
        $page = $this->pageRepository->get($id);
        $langs = $this->langRepository->allEnabled();

        $security = $page->security;
        if($security != null) {
            $securityType = $page->security->type;
        }
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

            'langs_select' => to_select($langs, 'name', 'slug', [null => __('Any')]),
            'langs' => $langs,
            'correspondingParents' => $this->pageRepository->getCorrespondingParents($langs, $page),

            'securityType' => $securityType->name,
            'securityData' => unserialize($security->data),
            'groups' => to_select($this->membergroupRepository->all(), 'name', 'id'),

            'componentList' => '',
        ]);
    }

    public function moduleareaList($pageId) {
        $moduleAreas = $this->moduleAreaRepository->getAllModuleAreaByThemeName($this->themeRepository->getCurrentThemeName());
        return view('pages.modulearealist')->with([
            'moduleAreas' => $moduleAreas,
            'pageId' => $pageId
        ]);
    }

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


    public function moduleList($pageId){
        $modules = $this->moduleRepository->getAllModulesByPage($pageId);
        return view('pages.modulelist')->with([
            'modules' => $modules
        ]);
    }

    public function update(UpdateRequest $request, $id){

        $enabledLang = om_config('om_enable_front_langauge');

        // make sur the slug is unique
        $validator = Validator::make($request->all(), [
            'slug' => [
                Rule::unique('pages')->ignore($id),
            ],
        ]);

        // send back with errors if the validation fails
        if ($validator->fails()) {
            toast()->error(__('Errors while saving the page'));
            return redirect()
                ->route('admin.pages.edit', ['id' => $id, 'tab' => $request->input('tab')])
                ->withErrors($validator)
                ->withInput();
        }

        $page = $this->pageRepository->get($id);


        // clear lang relation if the lang of the page is changed
        if($enabledLang){
            $this->pageLangRelRepository->clearRelIfLangChanged($page, $request->all());
        }

        // update the page
        $this->pageRepository->update($page, $request->all());

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
            case 'bymember':
                $this->pageSecurityRepository->update(
                    $page->security,
                    $this->pageSecurityTypeRepository->getSecurityMember(),
                    [
                        'membergroup' => $request->input('security_membergroup')
                    ]
                );
                break;
            case 'none' :
            default :
                $this->pageSecurityRepository->update(
                    $page->security,
                    $this->pageSecurityTypeRepository->getSecurityNone()
                );
                break;
        }


        $cs = $this->moduleRepository->getAllComponentsByPage($id);

        foreach($cs as $c) {
            Type::FormSave($c->fkPlugin, $c->id, $id);
        }

        toast()->success(__('Page saved'));
        return redirect()->route('admin.pages.edit', ['id' => $page->id, 'tab' => $request->input('tab')]);
    }


    public function delete($id){

    }


    public function enable($id){

    }

    public function getTable($lang = null){
        $enabledLang = om_config('om_enable_front_langauge');

        $pages = !$enabledLang ?
            $this->pageRepository->getPagesWithParent(null) :
            $this->pageRepository->getPageWithParentAndLang($lang, null);

        return view('pages.indextable')->with([
            'enabledLang' => $enabledLang,
            'currentLang' => $lang,
            'pages' => $pages,
        ]);
    }

    public function getPagesLevelZeroBylang(){
        /*
        $lang = $_GET['lang'];
        $pages = PageManager::GetAllPagesWithLangs($lang);
        $this->view->Set('pageList', $pages);
        return $this->view->RenderPartial();*/
    }

    function getAllPageByParentAndLang($pid, $lang, $idParent = null){
        return response()->json([
            'selected' => PageHelper::GetCorrespondingInLang($pid, $lang),
            'pages' => $this->pageRepository->getPageWithParentAndLang($lang, $idParent)
        ]);
    }


    #region component
    public function getCreateFormForComponent(){
        return view('pages.component.create')->with([
            'plugins' => $this->pluginRepository->getPluginsWithComponentsSupport()
        ]);
    }

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

    function createComponent($pageId, $pluginId) {
        $plugin = $this->pluginRepository->get($pluginId);
        $comp = $this->moduleRepository->createComponent($pageId, $plugin);
        return response()->json([
            'result'  => $comp->id
        ]);
    }
    function deleteComponent($id) {
        $result = $this->moduleRepository->delete($id);
        return response()->json([
            'result'  => $result
        ]);
    }

    // TODO
    public function getFormComponentSettings($compId) {
            $module = $this->moduleRepository->get($compId);

            $themeName = $this->themeRepository->getCurrentThemeName();

            $plugin = $this->pluginRepository->get($module->fkPlugin);

            $pluginName = $plugin->name;


            $pluginTemplates = $this->pluginRepository->getPluginTemplateViewsByTheme($themeName, $pluginName);
            array_unshift($pluginTemplates, null);

            $pluginTemplatesWithTitle = array();
            foreach($pluginTemplates as $template){
                if($template == null){
                    $pluginTemplatesWithTitle['null'] = __('Default');
                }
                else{
                    $pluginTemplatesWithTitle[$themeName . '/' . $pluginName . '/' . $template] = prettify_text($themeName) . ' - ' . prettify_text($pluginName) . ' - ' . without_ext(prettify_text($template));
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
            }
            else{
                $viewBag['pluginTemplate'] = 'null';
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

    // TODO :
    public function saveSettings(SaveSettingsRequest $request, $compId) {
        $module = $this->moduleRepository->get($compId);
        $args = json_decode($module->param, true);
        if(!isset($args['settings'])) $args['settings'] = array();
        $args['settings']['compId'] = $request->input('compId');
        $args['settings']['compTitle'] = $request->input('compTitle');
        $args['settings']['isHidden'] = $request->input('is_hidden') == 'true';
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

    // TODO :
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
    public function getCreateFormForModule(){
        return view('pages.module.create')->with([
            'plugins' => to_select($this->pluginRepository->getPluginsWithModulesSupport(), 'name', 'id')
        ]);
    }

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

    public function getEditFormForModule($moduleId, $pageId) {
        $module = $this->moduleRepository->get($moduleId);
        $pluginId = $module->fkPlugin;
        return Type::FormRender($pluginId, $moduleId, $pageId);
    }

    public function saveModule($moduleId) {
        $module = $this->moduleRepository->get($moduleId);
        $res = Type::FormSave($module->fkPlugin, $moduleId, $module->fkPage);
        return response()->json([
            'result'  => $res
        ]);
    }
    #endregion
}
