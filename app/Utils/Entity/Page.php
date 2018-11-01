<?php
namespace Omega\Utils\Entity;

use Illuminate\Support\Facades\DB;
use Omega\Repositories\PageRepository;
use Omega\Models\Page as PageModel;
use Omega\Utils\Path;

class Page{

    private $pageRepository;
    private $page;

    public $secure;
    public $securityType;
    public $securityData;

    private $exists;

    public function __construct($id = 0) {

        $this->pageRepository = new PageRepository(new PageModel());

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
        print_r($name);
        return $this->page->$name;
    }
	
	public function render()
	{
		//$this->content = $this->renderPhpFromContent($this->content);
		//$this->content = $this->renderMacroFromContent($this->content);
		//$this->content = $this->renderContentModule($this->content);
		if($this->secure && (isset($_SESSION['public']['connectedToPage_'.$this->id]) || isset($_SESSION['member_connected'])))
		{
			$this->renderComponent();	
		}
		if(!$this->secure)
		{
			$this->renderComponent();	
		}
		$this->doSecurityAction();
	}
	
    public function exists() {
        return isset($this->page);
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

    private function renderView($viewName, $viewData = array(), $renderOnlyContent = true) {
        extract($viewData);
        ob_start();
        require(ROOT . '/mvc/' . $viewName . '.php');
        $this->content .= ob_get_clean();
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
        $stmt = Dbs::select('*')
            ->from('om_module')
            ->where('fkPage', '=', '?')
            ->andwhere('isComponent', '=', '1')
            ->orderby('moduleOrder', 'ASC')
            ->prepare(array($this->id))
            ->run()
            ->getAllArray();

        $views = array();
        foreach($stmt as $c)
        {
            $stmt = Dbs::select('plugName')
                ->from('om_plugin')
                ->where('id', '=', '?')
                ->prepare(array($c['fkPlugin']))
                ->run();

            $pluginName = $stmt->getRow(0)->getString('plugName');

            $pluginClassName = 'Omega\\Plugin\\'. ucFirst($pluginName) .'\\FController' . ucFirst($pluginName);
            $instance = new $pluginClassName();
            $instance->idComponent = $c['id'];
            // register css and js of the component
            OmegaUtil::addDependencies($instance->registerDependencies());

            $data = Type::GetValues($c['fkPlugin'], $c['id'], $this->id);
            $args = json_decode($c['moduleParam'], true);

            // force using an other view defined in the settings of the component
            if(isset($args['settings']['pluginTemplate']) && $args['settings']['pluginTemplate'] != 'null'){
                $t = explode('/',  $args['settings']['pluginTemplate']);
                $theme = $t[0];
                $plugin = $t[1];
                $template = $t[2];
                $path = Path::Combine(THEMEPATH, $theme, 'template', $plugin, $template);
                $instance->forceView($path);
            }

            $isHidden = isset($args['settings']['isHidden']) ? $args['settings']['isHidden'] : false;
            if(!$isHidden) {
                $content = $instance->display($args, $data);

                $compId = '';
                $backgroundColor = 'transparent';
                $title = 'No title';
                if (isset($args['settings'])) {
                    $backgroundColor = isset($args['settings']['bgColor']) ? $args['settings']['bgColor'] : 'transparent';
                    $compId = isset($args['settings']['compId']) ? 'id="'.$args['settings']['compId'].'"' : '';
                    $title = isset($args['settings']['compTitle']) ? $args['settings']['compTitle'] : 'No title';
                }

                $component = $content;

                $style = $backgroundColor == 'transparent' ? '' : 'style="background-color: ' . $backgroundColor . ';"';
                $views[] = array(
                    'html' => '<section '.$compId.' ' . $style . ' class="component-container">' . $component . '</section>',
                    'title' => $title
                );
            }
        }
        return $views;
    }

    private function renderComponent() {
		
        $stmt = Dbs::select('*')
            ->from('om_module')
            ->where('fkPage', '=', '?')
            ->andwhere('isComponent', '=', '1')
            ->orderby('moduleOrder', 'ASC')
            ->prepare(array($this->id))
            ->run()
            ->getAllArray();

        foreach($stmt as $c)
        {
            $stmt = Dbs::select('plugName')
                ->from('om_plugin')
                ->where('id', '=', '?')
                ->prepare(array($c['fkPlugin']))
                ->run();

            $pluginName = $stmt->getRow(0)->getString('plugName');

            $pluginClassName = 'Omega\\Plugin\\'. ucFirst($pluginName) .'\\FController' . ucFirst($pluginName);
            $instance = new $pluginClassName();
            $instance->idComponent = $c['id'];
            // register css and js of the component

            OmegaUtil::addDependencies($instance->registerDependencies());

            $data = Type::GetValues($c['fkPlugin'], $c['id'], $this->id);
            $args = json_decode($c['moduleParam'], true);

            // force using an other view defined in the settings of the component
            if(isset($args['settings']['pluginTemplate']) && $args['settings']['pluginTemplate'] != 'null'){
                $t = explode('/',  $args['settings']['pluginTemplate']);
                $theme = $t[0];
                $plugin = $t[1];
                $template = $t[2];
                $path = Path::Combine(THEMEPATH, $theme, 'template', $plugin, $template);
                $instance->forceView($path);
            }

            $isHidden = isset($args['settings']['isHidden']) ? $args['settings']['isHidden'] : false;
            if(!$isHidden) {
                $content = $instance->display($args, $data);

                $compId = '';
                $isWrapped = true;
                $backgroundColor = 'transparent';
                if (isset($args['settings'])) {
                    $isWrapped = isset($args['settings']['isWrapped']) ? $args['settings']['isWrapped'] : true;
                    $backgroundColor = isset($args['settings']['bgColor']) ? $args['settings']['bgColor'] : 'transparent';
                    $compId = isset($args['settings']['compId']) ? 'id="'.$args['settings']['compId'].'"' : '';
                }

                if ($isWrapped) {
                    $component = '<div class="om-wrapper">' . $content . '</div>';
                } else {
                    $component = $content;
                }
                $style = $backgroundColor == 'transparent' ? '' : 'style="background-color: ' . $backgroundColor . ';"';
                $this->content .= '<section '.$compId.' ' . $style . ' class="component-container">' . $component . '</section>';
            }
        }
    }

    public function RenderCssTheme()
    {
        if($this->cssTheme != 'none')
        {

            $path = Path::Combine(
                theme_path(om_config('om_template_name')),
                'css',
                'theme',
                $this->cssTheme);

            if(!file_exists($path))
                return;


            $url = Url::CombAndAbs(
                ABSPATH,
                'theme',
                Config::get('om_template_name'),
                'css',
                'theme',
                $this->cssTheme
            );

            return '<link rel="stylesheet" href="'.$url.'" />';
        }
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