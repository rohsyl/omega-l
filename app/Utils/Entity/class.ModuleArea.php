<?php
namespace Omega\Library\Entity;

use Omega\Library\BLL\ModuleAreaManager;
use Omega\Library\Util\OmegaUtil;
use Omega\Library\Plugin\Type;
use Omega\Library\DTO\ModuleArea as MA;

/**
 * Helper for ModuleArea.
 * With this class you can create, delete and display ModuleArea.
 * @package Omega\Library\Entity
 */
class ModuleArea{

    /**
     * Create a modulearea for a theme
     * @param $name The name of the modulearea
     * @param $theme The name of the theme
     * @return bool true if success
     */
	public static function Create($name, $theme)
	{
	    if(!ModuleAreaManager::Exists($name, $theme)){
            $ma = new MA();
            $ma->areaName = $name;
            $ma->areaTheme = $theme;
            return ModuleAreaManager::Save($ma);
        }
        return true;
	}

    /**
     * Delete a modulearea identified by the given $name and $theme
     * @param $name The name of the modulearea
     * @param $theme The name of the theme
     * @return bool
     */
	public static function Delete($name, $theme) {
        return ModuleAreaManager::DeleteByNameAndTheme($name, $theme);
	}

    /**
     * Check if a modulearea exists
     * @param $name The name of the modulearea
     * @param $theme The name of the theme
     * @return bool True if exists
     */
	public static function Exists($name, $theme){
        return ModuleAreaManager::Exists($name, $theme);
    }

    /**
     * Display the content of a modulearea
     * @see Page
     * @param $page The Page
     * @param $name The name of the modulearea
     * @param $theme The name of the theme
     */
	public static function Display($page, $name, $theme)
	{
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
		echo $html;
	}
	
}