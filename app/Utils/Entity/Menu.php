<?php
namespace Omega\Library\Entity;

use Omega\Library;
use Omega\Library\Database\Dbs;
use Omega\Library\Util\Util;
use Omega\Library\Util\Ini;
use Omega\Library\Util\Url;
use Omega\Library\Language\Front\LangManager;
use Omega\Library\PMvc\PController;
use Omega\Library\BLL\MenuManager;

class Menu{

    /**
     * @var array
     */
	private $menuHtmlStruct;

    /**
     * @var string Active page URL
     */
    public static $currentPageUrl = '';

    /**
     * @see Page
     * @var Page Active Page
     */
    private $currentPage = null;

    public function __construct()
    {
        $this->menuHtmlStruct = array(
            'ul_main' => '<ul>%1$s</ul>',
            'li_nochildren' => '<li class="nav-item-%3$s"><a href="%1$s">%2$s</a></li>',
            'li_nochildrenactiv' => '<li class="active nav-item-%3$s"><a href="%1$s" class="active">%2$s</a></li>',
            'li_children' => '<li class="nav-item-%3$s"><a href="%1$s">%2$s</a>%4$s</li>',
            'ul_children' => '<ul>%1$s</ul>',
            'li_childrenactiv' => '<li class="active nav-item-%3$s"><a href="%1$s">%2$s</a>%4$s</li>'
        );
    }

    /**
     * Set the active page
     * @param $page Page
     */
    public function setCurrentPage($page) {
        $this->currentPage = $page;
    }
	
	public function setMenuHtmlStruct($menuHtmlStruct) {
		$this->menuHtmlStruct = $menuHtmlStruct;
	}

    /**
     * @deprecated
     * @return string
     */
	public function getPublic() {
        return 'getPublic() is deprecated, use getBySecurity() instead.';
	}

    /**
     * Get a menu by id
     * @param $id int The id of the menu
     * @return string The html structure
     */
	public function getMenuById($id) {
	    $menu = MenuManager::GetMenu($id);

		if($menu == null) return 'No menu';


        $menuLang = null;
        if(LangManager::isEnabled()){
            $menuLang = $menu->menuLang;
        }

		$menuJson = $menu->menuJson;
		$menuHtml = $this->getHtmlFromJson($menuJson, $this->menuHtmlStruct, $menuLang);

		return $menuHtml;
		
	}

    /**
     * Get the menu
     * @return string The html structure
     */
	public function getBySecurity() {

        $langEnabled = LangManager::isEnabled();

        $menu = null;
        if (isset($this->currentPage) && isset($this->currentPage->idMenu)) {
            $menu = MenuManager::GetMenu($this->currentPage->idMenu);
        }

        // else find menu by member group
        if (!isset($menu)) {
            $ids = $this->getMemberGroupOrPublic();
            foreach ($ids as $id) {

                $menu = $langEnabled ? MenuManager::GetMenuMainByMemberGroupAndLang($id, $_SESSION['front_lang']) : MenuManager::GetMenuMainByMemberGroup($id);

                if (isset($menu)) {
                    break;
                }
            }
        }

        // if no menu found, display public menu
        if (!isset($menu)) {
            return 'No menu';
        }

        $menuLang = null;
        if ($langEnabled) {
            $menuLang = $menu->menuLang;
        }

        $menuJson = $menu->menuJson;

        $menuHtml = $this->getHtmlFromJson($menuJson, $this->menuHtmlStruct, $menuLang);

        return $menuHtml;
    }
	
	private function getHtmlFromJson($json, $html, $lang = null, $level = -1, &$containesActive = false) {
		$level++;
		
		if(!is_array($json)) {
		
			$menu = json_decode($json, true);
		
		} else {
		
			$menu = $json;
			
		}
		
		$z = '';
		$current_page = substr(strrchr(strtok($_SERVER["REQUEST_URI"],'?'), "/"), 1);
		
		foreach($menu as $row) {	
		
            $url = $row['url'];
			$title = $row['title'];

			if(array_key_exists('children', $row)) {

				$children = $row['children'];

                $containesActive = false;
				
				$sub = $this->getHtmlFromJson($children, $html, $lang, $level, $containesActive);


				if($url == $current_page || $containesActive){

					$z .= sprintf($html['li_childrenactiv'], $this->PrepareUrl($url, $lang), $title, strtolower(Util::toTextKey($title)), $sub);
					$containesActive = true;
					
				} else {
				
					$z .= sprintf($html['li_children'], $this->PrepareUrl($url, $lang), $title, strtolower(Util::toTextKey($title)), $sub);
					
				}
				
			} else {

				if($url == $current_page) {

				    Menu::$currentPageUrl = $url;

					$z .= sprintf($html['li_nochildrenactiv'], $this->PrepareUrl($url, $lang), $title, strtolower(Util::toTextKey($title)));
					$containesActive = true;
					
				} else {
				
					$z .= sprintf($html['li_nochildren'], $this->PrepareUrl($url, $lang), $title, strtolower(Util::toTextKey($title)));
					
				}
				
			}
		}
		
		if($level == 0) {

			$z .= $this->getMemberPart();
			$z .= $this->getLanguagePart();
			$z = sprintf($html['ul_main'], $z);

		} else {

			$z = sprintf($html['ul_children'], $z);

		}
		return $z;
	}

	public function getMemberPart()
	{
		$html = $this->menuHtmlStruct;
		$z = '';

		if(Ini::Get('omega.member.enable')) {

			$title = '<span class="glyphicon glyphicon-user"></span> <span class="hidden-md hidden-lg">'.Library\oo('Member', true) .'</span>';
			$url = '#';

			if(isset($_SESSION['member_connected']) && $_SESSION['member_connected'] == true)
			{
				$subItems = sprintf($html['li_nochildren'], $this->PrepareUrl('/module/member/profil'), Library\oo('Profil', true), 'profil');
				$subItems .= sprintf($html['li_nochildren'], $this->PrepareUrl('/module/member/logout'), Library\oo('Logout', true), 'logout');
				$sub = sprintf($html['ul_children'], $subItems);
				$z .= sprintf($html['li_children'], $url, $title, 'member', $sub);

			}
			else
			{
				$subItems = sprintf($html['li_nochildren'], $this->PrepareUrl('/module/member/login'), Library\oo('Log in', true), 'login');
				$sub = sprintf($html['ul_children'], $subItems);
				$z .= sprintf($html['li_children'], $url, $title, 'member', $sub);
			}
			return $z;
		}
		return '';
	}
	
	public function getLanguagePart()
	{

        $langEnabled = LangManager::isEnabled();

		$html = $this->menuHtmlStruct;
		$z = '';

		// TODO use Front/Lang

		if($langEnabled) {

			$title = '<span class="glyphicon glyphicon-globe"></span> <span class="hidden-md hidden-lg">'.Library\oo('Language', true) .'</span>';
			$url = '#';

			$current_page = Entity::Page()->id;
			$current_page = $current_page != 0 ? $current_page : $_SERVER["REQUEST_URI"];
			$languages = LangManager::getAllLang();

			$subItems = '';
			foreach($languages as $lang)
			{
				$urlLang = PController::Url('language', 'change',array(
				    'target' => $lang->slug,
                    'referer' => $current_page
                ), true);
				$htmlType = $_SESSION['front_lang'] == $lang->slug ? 'li_nochildrenactiv' : 'li_nochildren';
				$subItems .= sprintf($html[$htmlType], $urlLang, $lang->name, $lang->slug);
			}


			$sub = sprintf($html['ul_children'], $subItems);
			$z .= sprintf($html['li_children'], $url, $title, 'language', $sub);

			return $z;
		}



		return '';
	}


    private function getMemberGroupOrPublic()
    {
        if(isset($_SESSION['member_id']))
        {
            $stmt = Dbs::select('fkMembergroup')
                ->from('om_member_membergroup')
                ->where('fkMember', '=', '?')
                ->prepare(array($_SESSION['member_id']))
                ->run();

            if($stmt->length() == 0){
                return array(1);
            }
            $membergroups = array();
            for($i = 0; $i < $stmt->length(); $i++){
                $membergroups[] = $stmt->getRow($i)->getInt('fkMembergroup');
            }
            return $membergroups;
        }
        else return array(1);
    }

    private function PrepareUrl($url, $lang = null)
    {

        // if url start with '#', 'http://' or 'https://', then leave it like that
        if(strpos($url, '#') === 0 || strpos($url, 'http://') === 0 || strpos($url, 'https://') === 0){
            return $url;
        }

        // change url in demo mode
        global $demoMode;
        if(isset($demoMode) && $demoMode){
            $path = parse_url($url, PHP_URL_PATH);
            $queryStrings = array();
            parse_str(parse_url($url, PHP_URL_QUERY), $queryStrings);

            return Url::CombAndAbs(ABSPATH, Url::Link('library/demo.php', array_merge(array('theme' => $_SESSION['demoTheme'], 'url' => urlencode($path)), $queryStrings)));
        }

        if(!isset($lang))
            return Url::CombAndAbs(ABSPATH, $url);


        $trimedUrl = trim($url, '/');
        // if lang slug already in $url, don't change the $url
        if(strpos($trimedUrl, $lang) === 0){
            return Url::CombAndAbs(ABSPATH, $url);
        }
        // else add lang slug
        return Url::CombAndAbs(ABSPATH, $lang, $url);

    }
}