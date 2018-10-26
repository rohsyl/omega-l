<?php

namespace Omega\Http\Controllers;

use Illuminate\Validation\Rule;
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
        /*
        has_right( 'page_update' , true );
        if(ParamUtil::IsValidUrlParamId('id')){

            $id = $_GET['id'];
            $page = PageManager::GetPage($id);

            if($page == null) die("This page doesn't exists...");

            $langs = LangManager::GetAllLangsWhereEnabled(true);
            $enabledLang = LangManager::IsEnableLanguage();

            $security = PageSecurityManager::GetPageSecurity($id);
            if($security != null){
                $securityType = PageSecurityTypeManager::GetSecurityType($security->fkType);
            }
            else{
                $securityType = PageSecurityTypeManager::GetSecurityNone();
                $security = PageSecurityManager::NewInstanceOfType($securityType, $page->id);
            }

            $form = new Form('getEditPageForm');
            if($form->isPosted()) {
                if(!$form->checkTokenInput()) {
                    die('Invalid token');
                }
                if(!$form->checkValue('pageName')){
                    Message::error(__('No title', true));
                    Redirect::toAction('page', 'add');
                }

                $urlAlias = PageManager::BuildUrlAlias($form->getValue('idText'));

                if($urlAlias == $page->idText || !PageManager::UrlAliasExists($urlAlias))
                {
                    $parent = Util::getRealNull($form->getValue('fkPageParent'));

                    $page->idText = $urlAlias;
                    $page->pageName = $form->getValue('pageName');
                    $page->pageSubtitle = $form->getValue('pageSubtitle');
                    $page->pageKeyWords = $form->getValue('pageKeyWords');
                    $page->pageModel = $form->getValue('pageModel');
                    $page->pageCssTheme = $form->getValue('pageCssTheme');
                    $page->pageMenu = $form->getValue('pageMenu');
                    $page->pageDateUpdated = date('Y-m-d H:i:s');
                    $page->fkPageParent = $parent;
                    $page->pageShowName = $form->checkValue('pageShowName');
                    $page->pageShowSubtitle = $form->checkValue('pageShowSubtitle');

                    if($enabledLang){
                        // save page relation to the corresponding page in other language
                        $page->pageLang = Util::getRealNull($form->getValue('lang'));
                        if($form->checkValue('plangs_rel')){
                            $langs_page_rel = $form->getValue('plangs_rel');
                            foreach($langs_page_rel as $lang => $rel){
                                PageLangRelManager::SavePageLangRel($id, Util::getRealNull($rel), $lang);
                            }
                        }
                    }

                    MenuManager::UpdateTitleInCustomMenu($form->getValue('pageName'), $id);
                    MenuManager::UpdateUrlAliasInCustomMenu($urlAlias, $id);

                    switch ($form->getValue('security'))
                    {
                        case 'bypassword':
                            $security->fkType = PageSecurityTypeManager::GetSecurityPassword()->id;
                            $security->data = serialize(array(
                                'message' => $form->getValue('securityMessage'),
                                'password' => $form->getValue('securityPassword')
                            ));
                            PageSecurityManager::SaveSecurity($security);
                            break;
                        case 'bymember':
                            $security->fkType = PageSecurityTypeManager::GetSecurityMember()->id;
                            $security->data = serialize(array(
                                'membergroup' => $form->getValue('fkMemberGroup')
                            ));
                            PageSecurityManager::SaveSecurity($security);
                            break;
                        case 'none' :
                        default :
                            PageSecurityManager::SaveNoneSecurity($id);
                            break;
                    }

                    $cs = ModuleManager::GetAllComponentsByPage($id);

                    foreach($cs as $c) {
                        Type::FormSave($c->fkPlugin, $c->id, $id);
                    }

                    $result = PageManager::Save($page);

                    if($result) {
                        Message::success(__('Page upated!', true));
                        Redirect::toAction('page', 'edit', array('id' => $_GET['id']));
                    }
                    else {
                        Message::error(__('Error while updating a page!', true));
                        Redirect::toAction('page', 'index');
                    }
                }
                else {
                    Message::error(sprintf(__('The url alias \'%s\' already exists !', true), $urlAlias));
                    Redirect::toAction('page', 'edit', array('id' => $_GET['id']));
                }
            }

            $this->view->Set('page', $page);
            $this->view->Set('enabledLang', $enabledLang);
            $this->view->Set('langs', $langs);
            $this->view->Set('correspondingParents', PageManager::GetCorrespondingParents($langs, $page));
            $this->view->Set('securityType', $securityType->name);
            $this->view->Set('securityData', unserialize($security->data));
            $this->view->Set('pages', PageManager::GetAllPagesWithParent(null));
            $this->view->Set('groups', MemberGroupManager::GetAllMemberGroups());
            $this->view->Set('menus', MenuManager::GetAllMenusWithLang($enabledLang ? $page->pageLang : null));
            $this->view->Set('countPage', PageManager::CountSameLevel($page->fkPageParent));
            $this->view->Set('menuUrl', Url::Action('apparence', 'menuindex'));
            $this->view->Set('models', ThemeManager::GetThemeTemplate(ThemeManager::GetCurrentThemeName()));
            $this->view->Set('cssThemes', ThemeManager::GetThemeCssThemes(ThemeManager::GetCurrentThemeName()));
            $this->view->Set('moduleareaList', $this->moduleareaList());
            $this->view->Set('componentList', $this->componentList());
            $this->view->Set('moduleList', $this->moduleList());

            return $this->view->Render();*/

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
    function createComponent() {
        $res = ModuleManager::CreateComponent($_GET['pageId'], $_GET['pluginId']);
        $this->view->Set('result', $res);
        return $this->view->RenderAjax();
    }


    function deleteComponent($id) {
        $result = $this->moduleRepository->delete($id);
        return response()->json([
            'result'  => $result
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

    public function saveModule() {
        if(ParamUtil::IsValidUrlParamId('moduleId')){
            $moduleId = $_GET['moduleId'];
            $module = ModuleManager::GetModule($moduleId);
            $pluginId = $module->fkPlugin;
            $pageId = $module->fkPage;
            $res = Type::FormSave($pluginId, $moduleId, $pageId);
            $this->view->Set('result', $res);
            return $this->view->RenderAjax();
        }
    }
    #endregion
}
