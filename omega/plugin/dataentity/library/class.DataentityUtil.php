<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 16.05.2018
 * Time: 09:29
 */

namespace Omega\Plugin\Dataentity\Library;


use Omega\Library\BLL\PluginManager;
use Omega\Library\Util\Util;
use Omega\Plugin\Dataentity\Library\DTO\DataEntityView;

class DataentityUtil
{
    /**
     * Get the name with a prefix.
     * Used to avoid possible similar name with other plugin form
     * @param $name string The name of the form
     * @return string The prefixed name
     */
    public static function GetPrefixedName($name)
    {
        return 'plugin_data_' . Util::SlugifyText($name);
    }

    /**
     * Get the id of this plugin
     * @return int The id
     */
    public static function GetPluginId()
    {
        $plugin = PluginManager::GetPluginByName('dataentity');
        return $plugin->id;
    }

    /**
     * Eval the given view with the given data
     * @param $view DataEntityView The view
     * @param $data array The data. It's a key-value array
     * @return string The view
     */
    public static function EvalView($view, $data = null)
    {
        // Output buffering
        ob_start();
        if(isset($data)) extract($data);
        eval('use Omega\Plugin\Dataentity\Library\DEUtils; ?> ' . $view->view);
        // return and clean the buffer
        return ob_get_clean();
    }

    public static function GetContentLayoutPlaceHolder(){
        return '[content]';
    }
    public static function GetTitleLayoutPlaceHolder(){
        return '[title]';
    }
}