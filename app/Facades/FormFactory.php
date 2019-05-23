<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 18.03.19
 * Time: 12:40
 */

namespace Omega\Facades;

use Illuminate\Support\Facades\Facade;
use Omega\Models\Form;

/**
 * @method static Form newForm(string $formName, string $pluginName, bool $isModule, bool $isComponent, string $title)
 * @method static void newFormEntry($formName, string $entryName, int $order, string $type, array $param, string $title, string $description, bool $mandatory)
 * @method static int deleteForm(string $formName)
 *
 * @see \Omega\Utils\Plugin\Form\FormFactory
 */
class FormFactory extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'omega:formfactory';
    }

}