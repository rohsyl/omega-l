<?php
namespace Omega\Library\Entity;

use Omega\Library;
use Omega\Library\Database\Dbs;
use Omega\Library\Util\Config;
use Omega\Library\Util\Redirect;
use Omega\Library\Util\Url;
use Omega\Library\Util\Path;
use Omega\Library\Util\MessageFront;
use Omega\Library\Util\OmegaUtil;
use Omega\Library\PMvc\PController;
use Omega\Library\Plugin\Type;
use Omega\Library\Language\Front\LangManager;
	
class Page{

    public $id;
    public $idText;
    public $title;
    public $isTitleShown;
    public $subtitle;
    public $isSubtitleShow;
    public $model;
    public $cssTheme;
    public $keyword;
    public $order;
    public $idParent;
    public $idCreator;
    public $isEnabled;
    public $idMenu;
    public $created;
    public $updated;
    public $lang;

    public $secure;
    public $securityType;
    public $securityData;

    private $exists;

    public function __construct($id = 0) {

        $page = Dbs::select('*')
            ->from('om_page')
            ->where('id', '=', '?')
            ->prepare(array($id))
            ->run();

        if($page->length() == 1){
            $page = $page->getRowArray(0);
            $this->id = $page['id'];
            $this->idText = $page['idText'];
            $this->title = $page['pageName'];
            $this->subtitle = $page['pageSubtitle'];
            $this->isTitleShown = $page['pageShowName'];
            $this->isSubtitleShow = $page['pageShowSubtitle'];
            $this->model = $page['pageModel'];
            $this->lang = $page['pageLang'];
            $this->cssTheme = $page['pageCssTheme'];
            $this->keyword = $page['pageKeyWords'];
            $this->order = $page['pageORDER'];
            $this->idParent = $page['fkPageParent'];
            $this->idCreator = $page['fkUser'];
            $this->isEnabled = $page['pageIsEnabled'];
            $this->idMenu = $page['pageMenu'] == 0 || !isset($page['pageMenu']) ? null : $page['pageMenu'];
            $this->created = $page['pageDateCreated'];
            $this->updated = date('d - m - Y', strtotime($page['pageDateUpdated']) );
            $this->exists = true;

            unset($page);
        }
        else
        {
            $this->id = 0;
            $this->idText = '';
            $this->title = '';
            $this->subtitle = '';
            $this->isTitleShown = true;
            $this->isSubtitleShow = true;
            $this->model = 'default';
            $this->lang = null;
            $this->cssTheme = 'none';
            $this->keyword = '';
            $this->order = '';
            $this->content = '';
            $this->idParent = '';
            $this->idCreator = '';
            $this->isEnabled = '';
            $this->idMenu = null;
            $this->created = '';
            $this->updated = '';
            $this->exists = false;
            unset($page);
        }
        $this->content = '';

        if($this->exists())
        {
            $stmt = Dbs::select('name', 'data')
                ->from('om_page_security')
                ->join('inner', 'om_page_security_type', 'om_page_security_type.id', 'fkType')
                ->where('fkPage', '=', '?')
                ->prepare(array($this->id))
                ->run();
            if($stmt->length() > 0)
            {
                $this->securityType = $stmt->getString(0, 'name');
                $this->securityData = unserialize($stmt->getString(0, 'data'));
                $this->secure = true;
            }
            else
            {
                $this->secure = false;
                $this->securityType = 'none';
                $this->securityData = array();
            }

        }
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
        return $this->exists;
    }

    public function doSecurityAction() {
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
        }
    }

    public function reload() {
        Redirect::toUrl(Url::CombAndAbs(ABSPATH, $this->idText));
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
				include Path::Combine(ROOT, 'om_macro', $matches[1]);
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
                THEMEPATH,
                Config::get('om_template_name'),
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

            echo '<link rel="stylesheet" href="'.$url.'" />';
        }
    }

    public function isVisibleTitle(){
        return $this->isTitleShown;
    }

    public function isVisibleSubTitle(){
        return $this->isSubtitleShow;
    }

    public function setVisibleTitle($b){
        $this->isTitleShown = $b;
    }

    public function setVisibleSubtitle($b){
        $this->isSubtitleShow = $b;
    }




    public static function GetHome($lang = null){

        $home_page_id = Config::get('om_home_page_id');

        $page = new Page($home_page_id);

        if(!$page->exists()) {
            $stmt = Dbs::select('id')
                ->from('om_page')
                ->where('pageIsEnabled', '=', '1')
                ->orderby('pageOrder', 'ASC')
                ->run();

            if ($stmt->length() <> 0){

                Config::set('om_home_page_id', $stmt->getRow(0)->getInt('id'));
                $home_page_id = Config::get('om_home_page_id');
                $page = new Page($home_page_id);
            }
        }
        if(!$page->exists()) {
            return null;
        }
        if(isset($lang) && $page->lang != $lang){
            $_SESSION['front_lang'] = $lang;
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
        $stmt = Dbs::select('P.id AS pid')
            ->from('om_page_lang_rel AS R')
            ->join('INNER', 'om_page AS P', 'P.id', 'R.fkPage1')
            ->where('R.fkPage2', '=', '?')
            ->andwhere('P.pageLang', 'LIKE', '?')
            ->prepare(array($id, $langSlug))
            ->run();
        if($stmt->length() == 0) return null;

        return $stmt->getInt(0, 'pid');
    }
}