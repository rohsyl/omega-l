<?php
namespace Omega\Library\Entity;

use Omega\Repositories\ModuleAreaRepository;

/**
 * Helper for ModuleArea.
 * With this class you can create, delete and display ModuleArea.
 * @package Omega\Library\Entity
 */
class ModuleArea{

    private static function GetRepository(){
        return new ModuleAreaRepository(new \Omega\ModuleArea());
    }

    /**
     * Create a modulearea for a theme
     * @param $name string The name of the modulearea
     * @param $theme string The name of the theme
     * @return bool true if success
     */
	public static function Create($name, $theme)
	{
	    if(!self::GetRepository()->exists($name, $theme)){
            $ma = self::GetRepository()->create($name, $theme);
            if(!isset($ma)){
                return false;
            }
        }
        return true;
	}

    /**
     * Delete a modulearea identified by the given $name and $theme
     * @param $name string The name of the modulearea
     * @param $theme string The name of the theme
     * @return bool
     */
	public static function Delete($name, $theme) {
        return  self::GetRepository()->deleteByName($name, $theme);
	}

    /**
     * Check if a modulearea exists
     * @param $name string The name of the modulearea
     * @param $theme string The name of the theme
     * @return bool True if exists
     */
	public static function Exists($name, $theme){
        return  self::GetRepository()->exists($name, $theme);
    }

    /**
     * Display the content of a modulearea
     * @see Page
     * @param $page Page The Page
     * @param $name string The name of the modulearea
     * @param $theme string The name of the theme
     */
	public static function Display($page, $name, $theme)
	{
	    /*
        if(self::Exists($name, $theme)){

            $contents = ModuleAreaManager::GetModuleAreaContentOnPage($page->id, $name, $theme);

            if(sizeof($contents) > 0)
            {
                ob_start();
                foreach($contents as $c)
                {
                    $data = Type::GetValues($c->fkPlugin, $c->moduleId, $page->id);
                    $plugin_param = json_decode($c->moduleParam, true);

                    $plugin_param['placement'] = 'modulearea';

                    $pluginNameUc = ucFirst($c->plugName);
                    $pluginName = 'Omega\\Plugin\\'.$pluginNameUc.'\\FController'.$pluginNameUc;
                    $plugin = new $pluginName();

                    if(method_exists($plugin, 'display'))
                    {
                        echo $plugin->display($plugin_param, $data);
                        if(method_exists($plugin, 'registerDependencies'))
                        {
                            OmegaUtil::addDependencies($plugin->registerDependencies());
                        }
                    }
                }
                $html = ob_get_clean();
            }
            else{
                $html = '&nbsp;';
            }
        }
        else {
            $html = "This modulearea does not exists...";
        }
		echo $html;*/
	}
	
}