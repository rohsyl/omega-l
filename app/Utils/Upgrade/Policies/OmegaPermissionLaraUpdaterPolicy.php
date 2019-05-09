<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 09.05.19
 * Time: 14:04
 */

namespace Omega\Utils\Upgrade\Policies;


use Omega\Policies\OmegaGate;
use rohsyl\laraupdater\Policies\ILaraUpdaterPolicy;

class OmegaPermissionLaraUpdaterPolicy implements ILaraUpdaterPolicy
{

    public function authorize($user)
    {
        if(config('laraupdater.permissions.parameters.ability') !== null) {

            return OmegaGate::forUser($user)->allows(config('laraupdater.permissions.parameters.ability'));

        }
        return false;
    }
}