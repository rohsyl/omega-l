<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 05.11.18
 * Time: 15:17
 */

namespace Omega\Facades;

use Illuminate\Support\Facades\Facade;
use Omega\Models\Lang;
use Omega\Utils\Entity\Menu;
use Omega\Utils\Entity\Page;
use Omega\Utils\Entity\Site;

/**
 * @method static void setPage(Page $page)
 * @method static void setMenu(Menu $menu)
 * @method static void setSite(Site $site)
 * @method static void setLang(Lang $lang)
 * @method static void setLangSlug(string $langSlug)
 * @method static Menu Menu()
 * @method static Page Page()
 * @method static Site Site()
 * @method static Lang Lang()
 * @method static string LangSlug()
 *
 * @see \Omega\Utils\Entity\Entity
 */
class Entity extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'omega:entity';
    }
}