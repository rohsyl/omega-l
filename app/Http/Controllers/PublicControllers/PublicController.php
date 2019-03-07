<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 04.03.19
 * Time: 10:37
 */

namespace Omega\Http\Controllers\PublicControllers;


use Omega\Facades\Entity;
use Omega\Facades\OmegaUtils;
use Omega\Utils\Entity\Site;

class PublicController
{
    public function __construct() {
        if(OmegaUtils::isInstalled()){
            Entity::setSite(new Site());
        }
    }
}