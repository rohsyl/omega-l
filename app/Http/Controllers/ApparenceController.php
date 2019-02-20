<?php

namespace Omega\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
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

/**
 * Class ApparenceController
 * @package Omega\Http\Controllers
 */
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
        parent::__construct();

        $this->themeRepository = $themeRepository;
        $this->moduleAreaRepository = $moduleAreaRepository;
        $this->menuRepository = $menuRepository;
        $this->membergroupRepository = $membergroupRepository;
        $this->pageRepository = $pageRepository;
        $this->langRepository = $langRepository;
    }

    #region theme

    /**
     * Get the list of theme
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function theme(){
        return view('apparence.theme.index')->with([
            'current' => $this->themeRepository->getCurrentThemeName(),
            'installed' => $this->themeRepository->getInstalledTheme(),
            'uninstalled' => $this->themeRepository->getUninstalledTheme()
        ]);
    }

    /**
     * Get the detail page of a theme
     * @param $name string The name of the theme
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function theme_detail($name) {
        return view('apparence.theme.detail')->with([
            'isCurrent' => $this->themeRepository->getCurrentThemeName() == $name,
            'theme' => $this->themeRepository->getByName($name),
            'templates' => $this->themeRepository->getThemeTemplate($name)
        ]);
    }

    /**
     * Publish the assets of the current theme
     * @param $name
     * @return \Illuminate\Http\RedirectResponse
     */
    public function theme_publish($name) {

        $code = Artisan::call('omega:theme:publish');

        $output = Artisan::output();

        if($code === 0)
            toast()->success(__('Publish done !'));
        else
            toast()->error(__('Error') . '<br />' . $output);

        return redirect()->back();
    }

    /**
     * Get the list of modulearea for the given theme name
     * @param $name string The name of the theme
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function theme_ma_list($name){
        return view('apparence.theme.ma_list')->with([
            'theme' => $name,
            'moduleArea' => $this->moduleAreaRepository->getAllModuleAreaByThemeName($name)
        ]);
    }

    /**
     * Get the form to add a new modulearea to a theme
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function theme_ma_add(){
        return view('apparence.theme.ma_add');
    }

    /**
     * Create a new modulearea for the given theme
     * @param CreateModuleAreaRequest $request
     * @param $name string The name of the theme
     * @return \Illuminate\Http\JsonResponse
     */
    public function theme_ma_create(CreateModuleAreaRequest $request, $name){
        $this->moduleAreaRepository->create(str_slug($request->input('modulearea'), '_'), $name);
        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Delete the given modulearea for the given theme
     * @param $name string The name of the theme
     * @param $area string The name of the modulearea
     * @return \Illuminate\Http\JsonResponse
     */
    public function theme_ma_delete($name, $area){
        $this->moduleAreaRepository->deleteByName($area, $name);
        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Set the given theme as the one in use. Automatically publish the assets
     * @param $name string The name of the theme
     * @return \Illuminate\Http\RedirectResponse
     */
    public function theme_useit($name) {

        // Set the current theme
        $this->themeRepository->setCurrentThemeName($name);
        toast()->success(__('Theme set'));

        // Publish the assets
        $code = Artisan::call('omega:theme:publish');
        $output = Artisan::output();
        if($code === 0)
            toast()->success(__('Theme publised !'));
        else
            toast()->error(__('Error') . '<br />' . $output);

        // Redirect back to the list of theme
        return redirect()->route('theme.index');
    }

    /**
     * Install a theme
     * @param $name string The name of the theme to install
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Uninstall a theme
     * @param $name string The name of the theme to uninstall
     * @return \Illuminate\Http\RedirectResponse
     */
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
    #endregion


    public function editor(){

    }


    #region menu
    public function menu(){
        return view('apparence.menu.index')->with([
            'menus' => $this->menuRepository->all(),
            'langEnabled' => om_config('om_enable_front_langauge')
        ]);
    }

    public function menu_add(){
        return view('apparence.menu.add')->with([
            'membergroups' => to_select($this->membergroupRepository->all(), 'name', 'id'),
            'langs' => to_select($this->langRepository->allEnabled(), 'name', 'slug'),
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
            'langs' => to_select($this->langRepository->allEnabled(), 'name', 'slug'),
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
            toast()->success(__('Menu deleted'));
            return redirect()->route('menu.index');
        }
        else{
            return view('apparence.menu.delete')
                ->with(['id' => $id]);
        }
    }
    #endregion
}
