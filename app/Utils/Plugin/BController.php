<?php 
namespace Omega\Utils\Plugin;

use Illuminate\Support\Facades\DB;
use Omega\Repositories\PluginRepository;
use Omega\Utils\Path;

class BController {

	protected $name;
	protected $id;
	protected $root;
	protected $meta;
	public $model;

	private $pluginRepository;

	public $idCurrentComponent = null;

	public function  __construct($name) {
        //$this->html = new Html();
		$this->name = $name;
		$this->root = Path::Combine(plugin_path(), $this->name);
		$this->meta = new PluginMeta($this->name);
		$this->pluginRepository = new PluginRepository(new \Omega\Plugin());

		if($this->isInstalled())
			$this->id = $this->getIdFromDatabase();
	}

	public static function getClassName($name)
	{
	    $nameF = camelize_plugin($name);
		return 'OmegaPlugin\\' . $nameF . '\\BController' . $nameF;
	}

	public function getId(){
	    return $this->id;
    }

	public function getMeta() {
		return $this->meta;
	}
	
	public function includeFile($filePath)
	{
		include_once ($this->root . DS . $filePath);
	}
	
	public function isInstalled() {
		$plugin = $this->pluginRepository->getByName($this->name);
		return $plugin != null;
	}	
	
	public function install() {
	    return true;
	}
	
	public function uninstall() {
		return true;
	}
	
	public function isEnabled() {
		if($this->isInstalled()) {
            $plugin = $this->pluginRepository->get($this->id);
            return $plugin->isEnabled;
		}
		return false;
	}
	
	public function enable() {
		if($this->isInstalled()) {
            return $this->pluginRepository->enable($this->id);
		}
		return true;
	}
	
	public function disable() {
		if($this->isInstalled()) {
            return $this->pluginRepository->disable($this->id);
		}
		return true;
	}
	
	protected function getAdminLink($action, $param = array()) {
	    $param = array_merge($param, array(
            'plugin' => $this->name,
            'action' => $action
        ));
	    return Url::Action('plugin', 'run', $param);

	}

	protected function runSql($sqlFileAbsPath) {

		$sql = file($sqlFileAbsPath);
		
		$query = '';
		foreach($sql as $l){
			if (substr(trim($l),0,2)!="--"){
				$query .= $l;
			}
		}

		$reqs = explode(';',$query);
		foreach($reqs as $req){
			try
			{
				if (trim($req) != '')
				    DB::statement($req);
			}
			catch(\Exception $e)
			{
				die('ERROR : '.$req . '<br />'. $e->getMessage());
			}
		}
	}

	private function getIdFromDatabase() {
        $plugin = $this->pluginRepository->getByName($this->name);
        return $plugin->id;
	}
}

