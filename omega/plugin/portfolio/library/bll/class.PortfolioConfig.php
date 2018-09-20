<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 31.03.18
 * Time: 15:33
 */

namespace Omega\Plugin\Portfolio\Library\BLL;

use Omega\Library\BLL\Manager;
use Omega\Library\Util\Config;

class PortfolioConfig extends Manager {

    private static $defaultSettings = array(
        'image-zoom' => false,
        'owl-nav' => false
    );

    private static $loadedSettings;

    public static function GetSettings(){
        $settings = Config::get('portfolio_config');
        $settings = isset($settings) ? json_decode($settings, true) : array();

        self::$loadedSettings = array_merge(self::$defaultSettings, $settings);
        return self::$loadedSettings;
    }

    public static function SetSettings($newSettings){
        if(self::$loadedSettings == null) self::GetSettings();
        
        self::$loadedSettings = array_merge(self::$loadedSettings, $newSettings);
        Config::set('portfolio_config', json_encode(self::$loadedSettings));
    }
}