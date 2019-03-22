<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 05.11.18
 * Time: 15:17
 */

namespace Omega\Facades;

use Illuminate\Support\Facades\Facade;
use Omega\Models\Config;
use Omega\Models\Lang;
use Omega\Utils\Entity\Menu;
use Omega\Utils\Entity\Page;
use Omega\Utils\Entity\Site;

/**
 * @method static void get(string $key)
 * @method static void load(array $configKeys)
 * @method static void updateIfExists(Config $config)
 * @method static void loadUserPermissionsInSession(User $user)
 *
 * @see \Omega\Utils\Entity\OmegaConfig
 */
class OmegaConfig extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'omega:config';
    }
}