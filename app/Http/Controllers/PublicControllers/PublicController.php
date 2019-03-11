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
use Omega\Http\Controllers\Controller;
use Omega\Utils\Entity\Site;

class PublicController extends Controller
{
    public function __construct() {
        if(OmegaUtils::isInstalled()){
            Entity::setSite(new Site());
        }
    }
}