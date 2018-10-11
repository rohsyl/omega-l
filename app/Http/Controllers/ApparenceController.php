<?php

namespace Omega\Http\Controllers;

use Illuminate\Http\Request;
use Omega\Http\Requests\Apparence\Menu\CreateRequest;
use Omega\Http\Requests\Apparence\Menu\UpdateRequest;
use Omega\Http\Requests\Apparence\Theme\CreateModuleAreaRequest;
use Omega\Repositories\LangRepository;
use Omega\Repositories\MembergroupRepository;
use Omega\Repositories\MenuRepository;
use Omega\Repositories\ModuleAreaRepository;
use Omega\Repositories\PageRepository;
use Omega\Repositories\ThemeRepository;
use Omega\Utils\Theme\Installer;

class ApparenceController extends AdminController
{
    private $themeRepository;
    private $moduleAreaRepository;
    private $menuRepository;
    private $membergroupRepository;
    private $pageRepository;
    private $langRepository;

    public function __construct(ThemeRepository $themeRepository,
                                ModuleAreaRepository $moduleAreaRepository,
                                MenuRepository $menuRepository,
                                MembergroupRepository $membergroupRepository,
                                PageRepository $pageRepository,
                                LangRepository $langRepository) {

        $this->themeRepository = $themeRepository;
        $this->moduleAreaRepository = $moduleAreaRepository;
        $this->menuRepository = $menuRepository;
        $this->membergroupRepository = $membergroupRepository;
        $this->pageRepository = $pageRepository;
        $this->langRepository = $langRepository;
    }

    public function theme(){
        return view('apparence.theme.index')->with([
            'current' => $this->themeRepository->getCurrentThemeName(),
            'installed' => $this->themeRepository->getInstalledTheme(),
            'uninstalled' => $this->themeRepository->getUninstalledTheme()
        ]);
    }


    public function theme_detail($name) {
        return view('apparence.theme.detail')->with([
            'theme' => $this->themeRepository->getByName($name),
            'templates' => $this->themeRepository->getThemeTemplate($name)
        ]);
    }

    public function theme_ma_list($name){
        return view('apparence.theme.ma_list')->with([
            'theme' => $name,
            'moduleArea' => $this->moduleAreaRepository->getAllModuleAreaByThemeName($name)
        ]);
    }

    public function theme_ma_add(){
        return view('apparence.theme.ma_add');
    }

    public function theme_ma_create(CreateModuleAreaRequest $request, $name){
        $this->moduleAreaRepository->create(str_slug($request->input('modulearea'), '_'), $name);
        return response()->json([
            'success' => true
        ]);
    }

    public function theme_ma_delete($name, $area){
        $this->moduleAreaRepository->deleteByName($area, $name);
        return response()->json([
            'success' => true
        ]);
    }

    public function theme_useit($name) {
        $this->themeRepository->setCurrentThemeName($name);
        toast()->success(__('Theme set'));
        return redirect()->route('theme.index');
    }

    public function theme_install($name) {
        if(!$this->themeRepository->isInstalled($name)) {

            $installer = $this->themeRepository->getInstaller($name);

            if(!isset($installer) || !$installer instanceof Installer){
                toast()->error(__('There is no installation file (install/install.php) for the theme ' . $name));
                return redirect()->back();
            }

            // Create the theme in the db
            $this->themeRepository->create($name, $installer->getData());

            // Execute the post_install action
            call_user_func($installer->getPostInstall(), $name);

            toast()->success(__('Theme installed'));
            return redirect()->route('theme.index');
        }
        toast()->info(__('Nothing to do'));
        return redirect()->route('theme.index');
    }

    public function theme_uninstall($name) {
        if($this->themeRepository->getCurrentThemeName() == $name){
            toast()->error(__('Can\'t delete the used theme...'));
            return redirect()->route('theme.index');
        }
        $this->moduleAreaRepository->deleteByTheme($name);
        $this->themeRepository->delete($name);
        toast()->success(__('Theme uninstalled'));
        return redirect()->route('theme.index');
    }

    public function theme_delete($name) {

    }



    public function editor(){

    }

    public function menu(){
        return view('apparence.menu.index')->with([
            'menus' => $this->menuRepository->all(),
            'langEnabled' => om_config('om_enable_front_langauge')
        ]);
    }

    public function menu_add(){
        return view('apparence.menu.add')->with([
            'membergroups' => to_select($this->membergroupRepository->all(), 'name', 'id'),
            'langs' => to_select($this->langRepository->allEnabled(), 'title', 'slug'),
            'langEnabled' => om_config('om_enable_front_langauge')
        ]);
    }

    public function menu_create(CreateRequest $request){
        $this->menuRepository->create($request->all());

        toast()->success(__('Menu created'));
        return redirect()->route('menu.index');
    }


    public function menu_edit($id){
        return view('apparence.menu.edit')->with([
            'menu' => $this->menuRepository->get($id),
            'membergroups' => to_select($this->membergroupRepository->all(), 'name', 'id'),
            'langEnabled' => om_config('om_enable_front_langauge')
        ]);
    }

    public function menu_edit_pages($id, $lang = null){

        if(om_config('om_enable_front_langauge')){
            $pages = $this->pageRepository->all($lang);
        }
        else {
            $pages = $this->pageRepository->all();
        }

        return view('apparence.menu.pageslist')->with([
           'pages' => $pages
        ]);
    }

    public function menu_update(UpdateRequest $request, $id){
        $menu = $this->menuRepository->get($id);
        $this->menuRepository->update($menu, $request->all());
        return response()->json([
            'success' => true,
        ]);
    }

    public function menu_delete($id, $confirm = null){
        if(isset($confirm) && $confirm){
            $this->menuRepository->delete($id);
        }
        else{
            return view('apparence.menu.delete')
                ->with(['id' => $id]);
        }
    }
}
