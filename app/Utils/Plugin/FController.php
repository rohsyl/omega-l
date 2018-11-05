<?php
namespace Omega\Utils\Plugin;

use Illuminate\Support\Facades\View;

abstract class FController {

	protected $root;
	public $name;

    private $meta;
	private $forceView;

    public $idComponent = null;

	public function  __construct($name) {
		$this->name = $name;
        $this->root =  plugin_path($this->name);
        $this->meta = new PluginMeta($this->name);
	}

    public static function getClassName($name)
    {
        $nameF = camelize_plugin($name);
        return 'OmegaPlugin\\' . $nameF . '\\FController' . $nameF;
    }

    public function getMeta() {
        return $this->meta;
    }

    protected function view($name){

        if(isset($this->forceView)){
            $path = $this->forceView;
        }
        else{
            $path = $this->root . DS . 'view' . DS . $name . '.blade.php';
        }

        return View::file($path)->with([
            'meta' => $this->getMeta()
        ]);
    }

	public function forceView($viewPath){
	    $this->forceView = $viewPath;
    }

    protected function json($data){
        return response()->json($data);
    }

	public function unique($key){
	    return $this->name . '_' . $this->idComponent . '_' . $key;
    }

    public abstract function registerDependencies();

    public abstract function display($args, $data);
}

