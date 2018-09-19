<?php
namespace Omega\Utils\Plugin;


abstract class FController {

	protected $root;
	public $name;

	private $forceView;

    public $idComponent = null;
	
	public function  __construct($name) {
		$this->root = PLUGINPATH . DS . $name . DS;
		$this->name = $name;
	}

	public function partialView( $name, $m = array()) {
		extract($m);
		ob_start();
        if(isset($this->forceView)){
            require($this->forceView);
            $this->forceView = null;
        }
        else{
		    require($this->root . 'view' . DS . 'view-'.$name.'.php');
        }
		return ob_get_clean();

	}

	public function abs_view( $path, $m = array() )
	{
		$m = $m == null ? array() : $m;
		extract($m);
		ob_start();
		require($path);
		return ob_get_clean();
	}

	public function view( $m = array() ) {
        $m = $m == null ? array() : $m;
		extract($m);
		if(isset($_GET['action']))
			$action = $_GET['action'];
		else 
			$action = 'display';


		ob_start();
        if(isset($this->forceView)){
            require($this->forceView);
            $this->forceView = null;
        }
        else{
            require($this->root . 'view' . DS . 'view-'.$action.'.php');
        }
		return ob_get_clean();
	}
	
	public function includeFile($filePath)
	{
		include_once ($this->root.'/'.$filePath);
	}
	
	public function partialSharedPluginView($name, $m = array())
	{
		extract($m);
		$filePath = APPPATH.'/view/plugin/view-'.$name.'.php';
		//if(file_exists($filePath))
		//{
			ob_start();
			require($filePath);
			return ob_get_clean();
		//}
		// null;
	}

	public function forceView($viewPath){
	    $this->forceView = $viewPath;
    }

	public function json($array) {
		
		return json_encode($array);
	}

	public function unique($key){
	    return $this->name . '_' . $this->idComponent . '_' . $key;
    }

    public abstract function display($args, $data);
}

