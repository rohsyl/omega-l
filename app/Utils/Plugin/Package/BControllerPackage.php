<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 15.06.19
 * Time: 15:25
 */

namespace Omega\Utils\Plugin\Package;


use Omega\Http\Controllers\AdminController;
use Omega\Repositories\PluginRepository;
use Omega\Utils\Plugin\PluginMeta;
use Omega\Models\Plugin as PluginModel;

class BControllerPackage extends AdminController
{
    /**
     * @var string The name of the plugin
     */
    protected $name;

    /**
     * @var int The id of the plugin
     */
    protected $id;

    /**
     * @var string The path to the plugin directory
     */
    protected $root;

    /**
     * @var PluginMeta MetaInformations about the plugin
     */
    private $meta;

    /**
     * @deprecated
     * @var mixed Dont know what is this
     */
    public $model;

    /**
     * @var PluginRepository
     */
    private $pluginRepository;

    /**
     * @var null|integer The id of the current component. Null if we are not in a component context
     */
    public $idCurrentComponent = null;

    private $formRendererComponent = null;

    private $formRendererModule = null;

    /**
     * BController constructor.
     * @param $name string The name of the plugin
     */
    public function  __construct($name) {
        parent::__construct();
        $this->name = $name;
        $this->root = plugin_path($this->name);
        $this->meta = new PluginMeta($this->name);
        $this->pluginRepository = new PluginRepository(new PluginModel());

        if($this->isInstalled())
            $this->id = $this->getIdFromDatabase();
    }

    /**
     * Get the id of the plugin
     *
     * @return int The id of the plugin
     */
    public function getId(){
        return $this->id;
    }

    /**
     * Get the meta object to access metainformations of the plugin
     *
     * @return PluginMeta The meta object
     */
    public function getMeta() {
        return $this->meta;
    }

    /**
     * Return true if the plugin is installed
     *
     * @return bool
     */
    public function isInstalled() {
        $plugin = $this->pluginRepository->getByName($this->name);
        return $plugin != null;
    }

    /**
     * This method can be overrided to execute some code after the installation of the plugin
     *
     * @return bool True if success
     */
    public function install() {
        return true;
    }

    /**
     * This method can be overrided to execute some code after the uninstallation of the plugin
     *
     * @return bool True if success
     */
    public function uninstall() {
        return true;
    }

    /**
     * Return true if the plugin is enabled
     *
     * @deprecated
     * @return bool
     */
    public function isEnabled() {
        if($this->isInstalled()) {
            $plugin = $this->pluginRepository->get($this->id);
            return $plugin->isEnabled;
        }
        return false;
    }

    /**
     * Enable the plugin
     *
     * @deprecated
     * @return bool
     */
    public function enable() {
        if($this->isInstalled()) {
            return $this->pluginRepository->enable($this->id);
        }
        return true;
    }

    /**
     * Disable the plugin
     *
     * @deprecated
     * @return bool
     */
    public function disable() {
        if($this->isInstalled()) {
            return $this->pluginRepository->disable($this->id);
        }
        return true;
    }

    /**
     * Return the view with the detail of the plugin
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function meta_view(){
        return view('plugin.meta')->with([
            'meta' => $this->getMeta()
        ]);
    }


    /**
     * Get the id of the plugin
     *
     * @return integer|null
     */
    private function getIdFromDatabase() {
        $plugin = $this->pluginRepository->getByName($this->name);
        return $plugin->id;
    }


    /**
     * Migrate all migrations files for the plugin
     */
    protected function migrate(){
        $exitCode = Artisan::call('omega:plugin:migrate', [
            'name' => $this->name, '--force' => true
        ]);
        return $exitCode;
    }

    /**
     * Reset all migrations files for this plugin
     */
    protected function reset(){
        $exitCode = Artisan::call('omega:plugin:migrate:reset', [
            'name' => $this->name, '--force' => true
        ]);
        return $exitCode;
    }


    /**
     * Set the form renderer for components
     *
     * @param AFormRenderer|null $formRenderer
     */
    protected function setComponentFormRenderer($formRenderer = null) {
        $this->formRendererComponent = $formRenderer;
    }

    /**
     * Set the form renderer for modules
     *
     * @param AFormRenderer|null $formRenderer
     */
    protected function setModuleFormRenderer($formRenderer = null) {
        $this->formRendererModule = $formRenderer;
    }

    /**
     * @return AFormRenderer|null
     */
    public function getFormRendererComponent()
    {
        return $this->formRendererComponent;
    }

    /**
     * @return AFormRenderer|null
     */
    public function getFormRendererModule()
    {
        return $this->formRendererModule;
    }
}