<?php
namespace Omega\Utils\Entity;

use Omega\Utils\Url;
use Omega\Repositories\LangRepository;
use Omega\Repositories\MemberRepository;
use Omega\Repositories\MenuRepository;
use Omega\Facades\Entity;

class Menu{

    private $menuRepository;
    private $langRepository;
    private $memberRepository;

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
        $this->menuRepository = new MenuRepository(new \Omega\Models\Menu());
        $this->langRepository = new LangRepository(new \Omega\Models\Lang());
        $this->memberRepository = new MemberRepository(new \Omega\Models\Member());

        $this->menuHtmlStruct = array(
            'ul_main' => '<ul>%1$s</ul>',
            'li_nochildren' => '<li class="nav-item-%3$s"><a href="%1$s" %4$s>%2$s</a></li>',
            'li_nochildrenactiv' => '<li class="active nav-item-%3$s"><a href="%1$s" class="active" %4$s>%2$s</a></li>',
            'li_children' => '<li class="nav-item-%3$s"><a href="%1$s" %5$s>%2$s</a>%4$s</li>',
            'ul_children' => '<ul>%1$s</ul>',
            'li_childrenactiv' => '<li class="active nav-item-%3$s"><a href="%1$s" %5$s>%2$s</a>%4$s</li>'
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
	    $menu = $this->menuRepository->get($id);

		if($menu == null) return 'No menu';


        $menuLang = null;
        if($this->langRepository->isEnabled()){
            $menuLang = $menu->lang;
        }

		$menuHtml = $this->getHtmlFromJson($menu->json, $this->menuHtmlStruct, $menuLang);

		return $menuHtml;
	}

    /**
     * Get the menu
     * @return string The html structure
     */
	public function getBySecurity() {

        $langEnabled = $this->langRepository->isEnabled();

        $menu = null;
        if (isset($this->currentPage) && isset($this->currentPage->idMenu)) {
            $menu = $this->menuRepository->get($this->currentPage->idMenu);
        }

        // else find menu by member group
        if (!isset($menu)) {
            $ids = $this->getMemberGroupOrPublic();
            foreach ($ids as $id) {

                $menu = $langEnabled
                    ? $this->menuRepository->getMenuMainByMemberGroupAndLang($id, session('front_lang'))
                    : $this->menuRepository->getMenuMainByMemberGroup($id);

                if (isset($menu)) {
                    break;
                }
            }
        }

        // if no menu found
        if (!isset($menu)) {
            return 'No menu';
        }

        $menuLang = null;
        if ($langEnabled) {
            $menuLang = $menu->lang;
        }

        $menuJson = $menu->json;

        $menuHtml = $this->getHtmlFromJson($menuJson, $this->menuHtmlStruct, $menuLang);

        return $menuHtml;
    }

    /**
     * Get the main menu by security or by id if the id is given as paramenter
     * @param null $id The id of the menu to retrive
     * @return array
     */
    public function getAsArray($id = null){
        $langEnabled = $this->langRepository->isEnabled();

        $menu = null;

        if(isset($id)){
            $menu = $this->menuRepository->get($id);
        }

        if (!isset($menu) && isset($this->currentPage) && isset($this->currentPage->idMenu)) {
            $menu = $this->menuRepository->get($this->currentPage->idMenu);
        }

        // else find menu by member group
        if (!isset($menu)) {
            $ids = $this->getMemberGroupOrPublic();
            foreach ($ids as $id) {

                $menu = $langEnabled
                    ? $this->menuRepository->getMenuMainByMemberGroupAndLang($id, session('front_lang'))
                    : $this->menuRepository->getMenuMainByMemberGroup($id);

                if (isset($menu)) {
                    break;
                }
            }
        }

        // if no menu found
        if (!isset($menu)) {
            return [];
        }

        return [
            'lang' => $langEnabled ? $menu->lang : null,
            'menu' => json_decode($menu->json)
        ];
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
			$isNewTab = isset($row['isnewtab']) ? $row['isnewtab'] : false;

			$target = $isNewTab ? 'target="_blank"' : '';

			if(array_key_exists('children', $row)) {

				$children = $row['children'];

                $containesActive = false;
				
				$sub = $this->getHtmlFromJson($children, $html, $lang, $level, $containesActive);


				if($url == $current_page || $containesActive){

					$z .= sprintf($html['li_childrenactiv'], $this->PrepareUrl($url, $lang), $title, strtolower(str_slug($title)), $sub, $target);
					$containesActive = true;
					
				} else {
				
					$z .= sprintf($html['li_children'], $this->PrepareUrl($url, $lang), $title, strtolower(str_slug($title)), $sub, $target);
					
				}
				
			}
			else {

				if($url == $current_page) {

				    self::$currentPageUrl = $url;

					$z .= sprintf($html['li_nochildrenactiv'], $this->PrepareUrl($url, $lang), $title, strtolower(str_slug($title)), $target);
					$containesActive = true;
					
				} else {
				
					$z .= sprintf($html['li_nochildren'], $this->PrepareUrl($url, $lang), $title, strtolower(str_slug($title)), $target);
					
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

		if(config('omega.member.enabled')) {

			$title = '<span class="glyphicon glyphicon-user"></span> <span class="hidden-md hidden-lg">'.__('Member') .'</span>';
			$url = '#';

			if(isset($_SESSION['member_connected']) && $_SESSION['member_connected'] == true)
			{
				$subItems = sprintf($html['li_nochildren'], $this->PrepareUrl('/module/member/profil'), __('Profil'), 'profil', '');
				$subItems .= sprintf($html['li_nochildren'], $this->PrepareUrl('/module/member/logout'), __('Logout'), 'logout', '');
				$sub = sprintf($html['ul_children'], $subItems);
				$z .= sprintf($html['li_children'], $url, $title, 'member', $sub, '');

			}
			else
			{
				$subItems = sprintf($html['li_nochildren'], $this->PrepareUrl('/module/member/login'), __('Log in'), 'login', '');
				$sub = sprintf($html['ul_children'], $subItems);
				$z .= sprintf($html['li_children'], $url, $title, 'member', $sub, '');
			}
			return $z;
		}
		return '';
	}
	
	public function getLanguagePart()
	{

        $langEnabled = $this->langRepository->isEnabled();

		$html = $this->menuHtmlStruct;
		$z = '';

		// TODO use Front/Lang

		if($langEnabled) {

			$title = '<span class="glyphicon glyphicon-globe"></span> <span class="hidden-md hidden-lg">'.__('Language') .'</span>';
			$url = '#';

			$current_page = Entity::Page()->id;
			$current_page = $current_page != 0 ? $current_page : url()->previous();
			$languages = $this->langRepository->allEnabled();

			$subItems = '';
			foreach($languages as $lang)
			{
			    if(session('front_lang') == $lang->slug){
                    $urlLang = Page::GetUrl($current_page);
                }
                else{
                    $urlLang = route('public.language.change', [
                        'target' => $lang->slug,
                        'referer' => $current_page
                    ]);
                }
				$htmlType = session('front_lang') == $lang->slug ? 'li_nochildrenactiv' : 'li_nochildren';
				$subItems .= sprintf($html[$htmlType], $urlLang, $lang->name, $lang->slug, '');
			}


			$sub = sprintf($html['ul_children'], $subItems);
			$z .= sprintf($html['li_children'], $url, $title, 'language', $sub, '');

			return $z;
		}



		return '';
	}


    private function getMemberGroupOrPublic()
    {
        if(session()->has('member_id')) {
            $member = $this->memberRepository->get(session('member_id'));

            if($member->membergroups->count() == 0){
                return array(1);
            }
            return $member->membergroups->pluck('id');
        }
        else return array(1);
    }

    /**
     * Format an URL
     * @param $url string The URL
     * @param null $lang The lang
     * @return string The new URL
     */
    public function PrepareUrl($url, $lang = null)
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

            return Url::CombAndAbs(url('/'), Url::Link('library/demo.php', array_merge(array('theme' => $_SESSION['demoTheme'], 'url' => urlencode($path)), $queryStrings)));
        }

        if(!isset($lang))
            return Url::CombAndAbs(url('/'), $url);


        $trimedUrl = trim($url, '/');
        // if lang slug already in $url, don't change the $url
        if(strpos($trimedUrl, $lang) === 0){
            return Url::CombAndAbs(url('/'), $url);
        }
        // else add lang slug
        return Url::CombAndAbs(url('/'), $lang, $url);

    }
}