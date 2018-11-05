<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 05.11.18
 * Time: 15:37
 */

namespace Omega\Facades;

use Illuminate\Support\Facades\Facade;
use Omega\Utils\Entity\Page;

/**
 * @method static void Create(string $name, string $theme)
 * @method static void Delete(string $name, $theme)
 * @method static boolean Exists(string $name, string $theme)
 * @method static string Display(Page $page, string $name, string $theme)
 *
 * @see \Omega\Utils\Entity\ModuleArea
 */
class ModuleArea extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'omega:modulearea';
    }
}