<?php
namespace Omega\Utils\Entity;

use Omega\Facades\OmegaUtils;
use Omega\Repositories\ModuleAreaRepository;
use Omega\Utils\Path;
use Omega\Utils\Plugin\Plugin;
use Omega\Utils\Plugin\Type;
use Omega\Utils\Theme\ComponentView;

/**
 * Helper for ModuleArea.
 * With this class you can create, delete and display ModuleArea.
 * @package Omega\Library\Entity
 */
class ModuleArea{

    private function GetRepository(){
        return new ModuleAreaRepository(new \Omega\Models\ModuleArea());
    }

    /**
     * Create a modulearea for a theme
     * @param $name string The name of the modulearea
     * @param $theme string The name of the theme
     * @return bool true if success
     */
	public function Create($name, $theme)
	{
	    if(!$this->GetRepository()->exists($name, $theme)){
            $ma = $this->GetRepository()->create($name, $theme);
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
	public function Delete($name, $theme) {
        return  $this->GetRepository()->deleteByName($name, $theme);
	}

    /**
     * Check if a modulearea exists
     * @param $name string The name of the modulearea
     * @param $theme string The name of the theme
     * @return bool True if exists
     */
	public function Exists($name, $theme){
        return  $this->GetRepository()->exists($name, $theme);
    }

    /**
     * Display the content of a modulearea
     * @see Page
     * @param $page Page The Page
     * @param $name string The name of the modulearea
     * @param $theme string The name of the theme
     */
	public function Display($page, $name, $theme)
	{
        $html = __('This modulearea does not exists...');
        if(self::Exists($name, $theme)){

            $modulearea = self::GetRepository()->getByNameAndThemeNameWithRel($name, $theme);


            $html = '';
            foreach($modulearea->positions as $position)
            {
                if(!isset($position->fkPage) || $position->fkPage == $page->id)
                {
                    if(!om_config('om_enable_front_langauge') || $position->lang == null || $position->lang == $page->lang)
                    {
                        $data = Type::GetValues($position->module->plugin->id, $position->module->id, $page->id);
                        $plugin_param = json_decode($position->module->param, true);

                        $plugin_param['placement'] = 'modulearea';

                        $plugin = Plugin::FInstance($position->module->plugin->name);


                        if(method_exists($plugin, 'display'))
                        {
                            $defaultComponentView = new ComponentView(
                                $position->module->plugin->name,
                                'display',
                                '*',
                                Path::Combine($position->module->plugin->name, 'default'),
                                'Theme Default'
                            );
                            $defaultComponentView->setThemeName(\Omega\Facades\Entity::Site()->template_name);

                            // force using an other view defined in the settings of the component
                            if(file_exists($defaultComponentView->buildPath())) {
                                $plugin->forceView($defaultComponentView->getViewName(), $defaultComponentView->buildPath());
                            }


                            $content = $plugin->display($plugin_param, $data);

                            $html .= view('public.module')->with([
                                'content' => $content,
                                'plugin' => $plugin,
                            ])->render();


                            if(method_exists($plugin, 'registerDependencies'))
                            {
                                OmegaUtils::addDependencies($plugin->registerDependencies());
                            }
                        }
                    }
                }
            }
        }
		return $html;
	}
	
}