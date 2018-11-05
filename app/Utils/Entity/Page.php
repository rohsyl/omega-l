<?php
namespace Omega\Utils\Entity;

use Illuminate\Support\Facades\DB;
use Omega\Facades\OmegaUtils;
use Omega\Models\Module;
use Omega\Repositories\ModuleRepository;
use Omega\Repositories\PageRepository;
use Omega\Models\Page as PageModel;
use Omega\Utils\Path;
use Omega\Utils\Plugin\Plugin;
use Omega\Utils\Plugin\Type;

class Page{

    private $pageRepository;
    private $moduleRepository;
    private $page;

    public $secure;
    public $securityType;
    public $securityData;

    public $content;

    public function __construct($id = 0) {

        $this->pageRepository = new PageRepository(new PageModel());
        $this->moduleRepository = new ModuleRepository(new Module());

        $this->page = $this->pageRepository->get($id);

        if($this->exists())
        {
            if(isset($this->page->security->type)) {
                $this->secure = true;
                $this->securityType = $this->page->security->type->name;
                $this->securityData = unserialize($this->page->security->data);
            }
            else {
                $this->secure = false;
                $this->securityType = 'none';
                $this->securityData = array();
            }

        }
    }


    public function __get($name){
        return $this->page->$name;
    }
	
	public function render()
	{
		if($this->secure && (isset($_SESSION['public']['connectedToPage_'.$this->id]) || isset($_SESSION['member_connected'])))
		{
			$this->renderComponent();	
		}
		else if($this->securityType == 'none')
		{
			$this->renderComponent();	
		}
		$this->doSecurityAction();
	}
	
    public function exists() {
        return isset($this->page) && $this->page->exists();
    }

    public function doSecurityAction() {
        /*
        switch ($this->securityType)
        {
            case 'bypassword':
                if(!isset($_SESSION['public']['connectedToPage_'.$this->id]))
                {
                    $hasLogin = false;
                    $hasError = false;
                    if(isset($_POST['securityDoLogin']))
                    {
                        $hasLogin = true;
                        $password = $_POST['securityPassword'];

                        if($password == $this->securityData['password'])
                        {
                            $_SESSION['public']['connectedToPage_'.$this->id] = true;
                            $this->reload();
                        }
                        else
                        {
                            $hasError = true;
                            $this->securityData['error'] = 'Mots de passe erroné !';
                        }
                    }
                    if(!$hasLogin || ($hasLogin && $hasError))
                    {
                        $this->renderView('view/webpart/page-security-bypassword', $this->securityData);
                        $this->model = 'default';
                    }
                }
                else
                {
                    $this->renderView('view/webpart/page-security-bypassword-logout', $this->securityData);

                    if(isset($_GET['logout']))
                    {
                        unset($_SESSION['public']['connectedToPage_'.$this->id]);
                        $this->reload();
                    }
                }
                break;

            case 'bymember':

                $error403 = function() {
                    if(isset($_SESSION['member_connected']) && $_SESSION['member_connected'] == true) {
                        MessageFront::error(Library\oo('You do not have permission to see this page', true));
                        Redirect::toUrl(PController::Url('error', '_403', true));
                    }
                    else {
                        MessageFront::error(Library\oo('You do not have permission to see this page. Please login....', true));
                        Redirect::toUrl(PController::Url('member', 'login', true));
                    }
                };

                if(isset($_SESSION['member_connected']) && $_SESSION['member_connected'] == true) {

                    if($this->securityData['membergroup'] != 1)
                    {
                        if (!OmegaUtil::member_IsInGroup($_SESSION['member_id'], $this->securityData['membergroup']))
                        {
                            $error403();
                        }
                    }
                }
                else $error403();
                break;
        }*/
    }

    public function reload() {
        return redirect(self::GetUrl($this->page->id));
    }
		
    public static function RenderSpecialContent($content)
    {
        $p = new Page();
        return $p->renderMacroFromContent($p->renderPhpFromContent($content));
    }

    public function renderMacroFromContent($content) {
        $content = preg_replace_callback(
            '#\[macro\=(.+)\]\[\/macro\]#iUs',
            function($matches) {

                ob_start();
				include Path::Combine(macro_path(), $matches[1]);
				$html = ob_get_clean();
                
                return $html;
            },
            $content
        );
        return $content;
    }
	
    public function renderPhpFromContent($content) {
        ob_start();
        eval('?>' . $content);
        return ob_get_clean();
    }

    public function getComponentsViewArray(){

        $components = $this->moduleRepository->getAllComponentsByPage($this->id);


        $views = array();
        foreach($components as $component)
        {

            $instance = Plugin::FInstance($component->plugin->name);

            $instance->idComponent = $component->id;

            // register css and js of the component
            OmegaUtils::addDependencies($instance->registerDependencies());

            $data = Type::GetValues($component->plugin->id, $component->id, $this->id);

            $args = json_decode($component->param, true);

            if(isset($args['settings']['pluginTemplate']) && $args['settings']['pluginTemplate'] != 'null'){
                $t = explode('/',  $args['settings']['pluginTemplate']);
                $plugin = $t[1];
                $template = $t[2];
                $path = 'theme::template.'.$plugin.'.'.$template;
                $instance->forceView($path);
            }

            $isHidden = isset($args['settings']['isHidden']) ? $args['settings']['isHidden'] : false;
            if(!$isHidden) {
                $content = $instance->display($args, $data);

                $compId = null;
                $isWrapped = false;
                $backgroundColor = 'transparent';
                $title = 'No title';
                if (isset($args['settings'])) {
                    $backgroundColor = isset($args['settings']['bgColor']) ? $args['settings']['bgColor'] : 'transparent';
                    $compId = isset($args['settings']['compId']) ? 'id="'.$args['settings']['compId'].'"' : null;
                    $title = isset($args['settings']['compTitle']) ? $args['settings']['compTitle'] : 'No title';
                }
                $style = $backgroundColor == 'transparent' ? null : 'style="background-color: ' . $backgroundColor . ';"';

                $views[] = [
                    'html' => $this->content .= view('public.section')->with([
                        'compId' => $compId,
                        'style' => $style,
                        'isWrapped' => $isWrapped,
                        'content' => $content,
                    ])->render(),
                    'title' => $title
                ];
            }
        }
        return $views;
    }

    private function renderComponent() {

        $components = $this->moduleRepository->getAllComponentsByPage($this->id);

        foreach($components as $component)
        {

            $instance = Plugin::FInstance($component->plugin->name);

            $instance->idComponent = $component->id;

            // register css and js of the component
            OmegaUtils::addDependencies($instance->registerDependencies());

            $data = Type::GetValues($component->plugin->id, $component->id, $this->id);

            $args = json_decode($component->param, true);

            // force using an other view defined in the settings of the component
            if(isset($args['settings']['pluginTemplate']) && $args['settings']['pluginTemplate'] != 'null'){
                $t = explode('/',  $args['settings']['pluginTemplate']);
                $plugin = $t[1];
                $template = $t[2];
                $path = 'theme::template.'.$plugin.'.'.$template;
                $instance->forceView($path);
            }

            $isHidden = isset($args['settings']['isHidden']) ? $args['settings']['isHidden'] : false;
            if(!$isHidden) {
                $content = $instance->display($args, $data);

                $compId = null;
                $isWrapped = true;
                $backgroundColor = 'transparent';
                if (isset($args['settings'])) {
                    $isWrapped = isset($args['settings']['isWrapped']) ? $args['settings']['isWrapped'] : true;
                    $backgroundColor = isset($args['settings']['bgColor']) ? $args['settings']['bgColor'] : 'transparent';
                    $compId = isset($args['settings']['compId']) ? 'id="'.$args['settings']['compId'].'"' : null;
                }
                $style = $backgroundColor == 'transparent' ? null : 'style="background-color: ' . $backgroundColor . ';"';

                $this->content .= view('public.section')->with([
                    'compId' => $compId,
                    'style' => $style,
                    'isWrapped' => $isWrapped,
                    'content' => $content,
                ])->render();
            }
        }
    }

    public function getCssTheme()
    {
        if($this->cssTheme != 'none') {
            $path = Path::Combine(
                theme_css_path(om_config('om_theme_name')),
                $this->cssTheme
            );

            if(!file_exists($path))
                return [];

            $url = theme_asset_csstheme($this->cssTheme);
            return [$url];
        }
        return [];
    }

    public function isVisibleTitle(){
        return $this->page->showTitle;
    }

    public function isVisibleSubTitle(){
        return $this->page->showSubTitle;
    }




    public static function GetHome($lang = null){

        $home_page_id = om_config('om_home_page_id');

        $page = new Page($home_page_id);

        if(!$page->exists()) {
            $pageId = PageModel::where('isEnabled', 1)->orderBy('order')->first();

            if (isset($pageId)){
                om_config(['om_home_page_id' => $pageId->id]);
                $page = new Page($pageId->id);
            }
            else
            {
                return abort(404);
            }
        }
        if(isset($lang) && $page->lang != $lang){
            session(['front_lang' => $lang]);
            $home_page_id = self::GetCorrespondingInLang($home_page_id, $lang);
        }
        return $home_page_id;
    }

    public static function GetId($url){
        $langEnabled = LangManager::isEnabled();
        $parsedUrl = explode('/', $url);
        $page_idText = $langEnabled ? $parsedUrl[1] : $parsedUrl[0];

        $stmt = Dbs::select('id', 'pageLang')
            ->from('om_page')
            ->where('idText', 'LIKE', '?')
            ->prepare(array($page_idText))
            ->run();

        if($stmt->length() == 1){

            $pId = $stmt->getInt(0, 'id');
            $pageLang = $stmt->getString(0, 'pageLang');

            //Util::printR(array($pageLang, $_SESSION['front_lang'], $parsedUrl));
            //Library\Util\Util::printR($pId);

            if(!$langEnabled){
                return $pId;
            }

            if($pageLang != $parsedUrl[0]){
                $_SESSION['front_lang'] = $pageLang;

                // get page in other lang
                $pId = self::GetCorrespondingInLang($pId, $_SESSION['front_lang']);

                // redirect to new page if id not null, else 404
                Redirect::toUrl(self::GetUrl($pId));
            }

            return $pId;

        } else {

            return '_404';

        }
    }

    public static function GetUrl($id){
        $idText = Dbs::select('idText')
            ->from('om_page')
            ->where('id', '=', '?')
            ->prepare(array($id))
            ->runScalar();

        if(LangManager::isEnabled()){
            $lang = $_SESSION['front_lang'];
            if(!isset($lang)){
                $lang = LangManager::getCurrentLang()->slug;
            }
            return Url::CombAndAbs(ABSPATH, $lang, $idText);
        }
        return Url::CombAndAbs(ABSPATH, $idText);
    }

    public static function GetCorrespondingInLang($id, $langSlug){

        $stmt = DB::table('page_lang_rels')
            ->selectRaw('pages.id AS pid')
            ->join('pages', 'pages.id', 'page_lang_rels.fkPage1')
            ->where('page_lang_rels.fkPage2', $id)
            ->where('pages.lang', $langSlug);

        if($stmt->doesntExist()) return null;

        return $stmt->value('pid');
    }
}