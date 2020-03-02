<?php
namespace Omega\Utils\Plugin;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Omega\Utils\Path;

abstract class FController extends AbstractController {

    /**
     * @var string Full path to the plugin directory
     */
	protected $root;

    /**
     * @var string The name of the plugin
     */
	public $name;

    /**
     * @var PluginMeta The meta informations of the plugin
     */
    private $meta;

    /**
     * @var string Force the view to this one.
     */
	private $forceView;

    /**
     * @var null|integer The id of the current component
     */
    public $idComponent = null;

    /**
     * FController constructor.
     * @param $name
     */
	public function  __construct($name) {
		$this->name = $name;
        $this->root = plugin_path($this->name);
        $this->meta = new PluginMeta($this->name);
	}

    /**
     * Get the full classname of the plugin fcontroller
     * @param $name string The name of the plugin
     * @return string The classname
     */
    public static function getClassName($name)
    {
        $nameF = camelize_plugin($name);
        return 'OmegaPlugin\\' . $nameF . '\\FController' . $nameF;
    }

    /**
     * Get the meta
     * @return PluginMeta
     */
    public function getMeta() {
        return $this->meta;
    }

    /**
     * Get the view from the view directory
     * @param $name string The name of the view
     * @return \Illuminate\Contracts\View\View The view
     */
    public function view($name){

        if(isset($this->forceView['default'])) {
            $path = $this->forceView['default'];
        }
        elseif(isset($this->forceView[$name])){
            $path = $this->forceView[$name];
        }
        else{
            $path = $this->root . DS . 'view' . DS . $name . '.blade.php';
        }

        return View::file($path)->with([
            'meta' => $this->getMeta()
        ]);
    }

    /**
     * Force the view
     * @param $viewPath string The fill path to the view (blade)
     */
	public function forceView($viewName, $viewPath){
	    $this->forceView[$viewName] = $viewPath;
    }

    /**
     * Return json
     * @param $data array The data that will be encoded
     * @return JsonResponse
     */
    protected function json($data){
        return response()->json($data);
    }

    /**
     * Return an unique id
     * @param $key string A key
     * @return string The unique id
     */
	public function unique($key = null){
	    return $this->name . '_' . $this->idComponent . (isset($key) ? '_' . $key : '');
    }

    /**
     * Register dependecies of the plugin (js and css)
     * @return array|null
     */
    public abstract function registerDependencies();

    /**
     * Display a plugin's module in the page
     * @param $args array The parameter of the module
     * @param $data array The data of the module
     * @return mixed
     */
    public abstract function display($args, $data);

    /**
     * Return path to the given assets
     * @param $path
     * @return string
     */
    protected function asset($path){
        return plugin_asset($this->name, $path);
    }

    protected function includeFile($file)
    {
        $path = Path::Combine($this->root, $file);

        if(file_exists($path))
            include_once($path);
    }
}

