<?php 
namespace Omega\Utils\Plugin;

use Exception;
use Omega\Library\BLL\PluginManager;
use Omega\Library\DTO\Plugin;
use Omega\Library\Util\Header;
use Omega\Library\Util\Html;
use Omega\Library\Util\Path;
use Omega\Library\Database\Dbs;
use Omega\Library\Util\Url;
use Omega\Library\Util\Util;

class BController {

	protected $name;
	protected $id;
	protected $root;
	protected $meta;
	public $model;

	public $idCurrentComponent = null;

	public function  __construct($name) {
        $this->currentAction = isset($_GET['function']) ? $_GET['function'] : 'index';
        $this->currentController = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
        $this->html = new Html();
		$this->name = $name;
		$this->root = Path::Combine(PLUGINPATH, $name);
		$this->meta = new PluginMeta($this->name);

		if($this->isInstalled())
			$this->id = $this->getIdFromDatabase();
	}

	public static function getClassName($name)
	{
	    $nameF = ucfirst($name);
		return 'Omega\\Plugin\\' . $nameF . '\\BController' . $nameF;
	}

	public function getId(){
	    return $this->id;
    }

	public function getMeta()
	{
		return $this->meta;
	}
	
	public function includeFile($filePath)
	{
		include_once ($this->root.'/'.$filePath);
	}
	
	public function isInstalled() {
		$plugin = PluginManager::GetPluginByName($this->name);
		return $plugin != null;
	}	
	
	public function install() {
		if(!$this->isInstalled()) {
		    $plugin = new Plugin();
		    $plugin->plugName = $this->name;
		    $plugin->plugEnabled = true;
		    $result = PluginManager::Save($plugin);
            $this->id = $plugin->id;
            return $result;
		}
		return true;
	}
	
	public function uninstall() {
		return true;
	}
	
	public function isEnabled() {
		if($this->isInstalled()) {
            $plugin = PluginManager::GetPlugin($this->id);
            return $plugin->plugEnabled;
		}
		return false;
	}
	
	public function enable() {
		if($this->isInstalled()) {
            $plugin = PluginManager::GetPlugin($this->id);
            $plugin->plugEnabled = true;
            return PluginManager::Save($plugin);
		}
		return true;
	}
	
	public function disable() {
		if($this->isInstalled()) {
            $plugin = PluginManager::GetPlugin($this->id);
            $plugin->plugEnabled = false;
            return PluginManager::Save($plugin);
		}
		return true;
	}

	public function partialView( $name, $m = array()) {
		extract($m);
		ob_start();
		$path = Path::Combine($this->root, 'view', 'view-'.$name.'.php');
		require($path);
		return ob_get_clean();

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
	
	public function json($array) {
        Header::SetContentType(Header::CONTENT_TYPE_JSON);
		return json_encode($array);
	}
	
	public static function staticIsInstalled($name) {
        $plugin = PluginManager::GetPluginByName($name);
        return $plugin != null;
	}
	
	public static function staticGetAdminLink($name, $action, $param = array()) {
        $param = array_merge($param, array(
            'plugin' => $name,
            'action' => $action
        ));
        return Url::Action('plugin', 'run', $param);
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
				    Dbs::exec($req);
			}
			catch(Exception $e)
			{
				die('ERROR : '.$req . '<br />'. $e->getMessage());
			}
		}
	}
	
	public function view( $m = array() ) {
        $m = $m == null ? array() : $m;
		extract($m);
		if(isset($_GET['action']))
			$action = $_GET['action'];
		else 
			$action = 'display';
		
		ob_start();
			require($this->root.'/view/view-'.$action.'.php');
		return ob_get_clean();
	}

	private function getIdFromDatabase() {

        $plugin = PluginManager::GetPluginByName($this->name);
        return $plugin->id;
	}

	public function fieldName($name)
	{
		$fn = $this->name;
		if(isset($this->idCurrentComponent)) $fn .= '_'.$this->idCurrentComponent;
		$fn .= '_'.$name;
		return $fn;
	}
}

