<?php
namespace Omega\Library\Entity;

class Module{
	
	private $name = '';
	private $pluginName = '';
	private $pluginParams = array();
	
	public function __construct($name, $pluginName, $pluginParams) {
	
		$this->name = $name;
		$this->pluginName = $pluginName;
		$this->pluginParams = $pluginParams;
	}
	
	public function getName() 			{ return $this->name; }
	
	public function getPluginName() 	{ return $this->pluginName; }
	
	public function getPluginParams() 	{ return $this->pluginParams; }
	
	public function display() {
	
		$plugin = new Plugin($this->pluginName);
		$plugin->load('run', $this->pluginParams);
	}
	
	public static function DisplayById($id)
	{
		global $cache;

		$cacheKey = Ini::Get('omega.cache.modulekey');
		$maxTime = Ini::Get('omega.cache.maxtime');

		$html = $cache->get($cacheKey.$id);

		if($html == null) {

			$stmt = Dbs::select('plugName', 'moduleParam')
				->from('om_module')
				->join('inner', 'om_plugin', 'om_plugin.id', 'om_module.fkPlugin')
				->where('om_module.id', '=', '?')
				->prepare(array($id))
				->run();

			if ($stmt->length() > 0)
			{
				ob_start();

				$row = $stmt->getRow(0);

				$plugin_name = $row->getString('plugName');
				$plugin_param = json_decode($row->getString('moduleParam') ,true);
				$plugin_param['placement'] = 'content';

				include_once(Path::Combine(ROOT, 'om_plugin', $plugin_name, $plugin_name . '_Front.php'));

				$pluginName = 'Controller' . ucFirst($plugin_name) . '_Front';
				$plugin = new $pluginName();
				if (method_exists($plugin, 'display')) {
					echo $plugin->display($plugin_param);
					if(method_exists($plugin, 'registerDependencies'))
					{
						$dep = $plugin->registerDependencies();
						OmegaUtil::addDependencies($dep);
					}
				}

				$html = ob_get_clean();

				$cache->set($cacheKey.$id, $html, $maxTime);
			}
		}

		echo $html;
	}
}