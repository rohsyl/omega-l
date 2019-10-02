<?php


namespace Omega\Facades;


use Illuminate\Support\Facades\Facade;
use Omega\Utils\Theme\Installer;

/**
 * @method static string current()
 * @method static \Omega\Models\Theme get($name = null)
 * @method static Installer|null installer($name = null)
 * @method static bool installed($name = null)
 * @method static void setLangSlug(string $langSlug)
 * @method static \Omega\Models\Theme[] installedThemes()
 * @method static string[] notInstalledThemes()
 * @method static string[] templates($name = null)
 * @method static string[] styles($name = null)
 * @method static array colors($name = null)
 *
 * @see \Omega\Utils\Entity\Theme
 */
class Theme extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'omega:theme';
    }
}