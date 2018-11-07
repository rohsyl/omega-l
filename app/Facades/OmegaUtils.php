<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 05.11.18
 * Time: 15:46
 */

namespace Omega\Facades;

use Illuminate\Support\Facades\Facade;
use Omega\Models\User;

/**
 * @method static string GetCurrentUserAvatar()
 * @method static string GetUserAvatar(User $user)
 * @method static string GetCurrentUserName()
 * @method static string GetCurrentUserFullName()
 * @method static array getInstalledPlugin()
 * @method static string renderMeta()
 * @method static boolean isInstalled()
 * @method static void addDependencies(array $dependencies)
 * @method static string renderDependencies()
 * @method static string renderOmegaAssets()
 *
 * @see \Omega\Utils\OmegaUtils
 */
class OmegaUtils extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'omega:utils';
    }
}