<?php


namespace Omega\Facades;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Omega\Utils\Theme\Installer;

/**
 * @method static Collection displayedInMenu()
 * @method static Collection installed()
 * @method static array notInstalled()
 * @method static Collection components()
 * @method static Collection modules()
 * @method static array getPluginTemplateViewsByTheme($themeName, $pluginName)
 * @method static mixed isPluginTemplateUpToDate($pluginTemplateString)
 *
 * @see \Omega\Utils\Entity\Theme
 */
class Plugin extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'omega:plugin';
    }
}