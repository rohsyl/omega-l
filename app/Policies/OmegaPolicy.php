<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 22.02.19
 * Time: 13:07
 */

namespace Omega\Policies;


use Omega\Models\User;

class OmegaPolicy
{
    /**
     * @param $user User
     * @param $ability string
     * @return boolean
     */
    public function define($user, $ability){
        return $user->hasRight($ability);
    }
}