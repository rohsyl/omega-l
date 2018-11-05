<?php

namespace Omega\Http\Controllers;

use Omega\Facades\Entity;
use Omega\Utils\Entity\Site;

class PublicController extends Controller
{

    public function __construct() {
        Entity::setSite(new Site());
    }

    public function home($lang = null)
    {
        return page()->withLang($lang);
    }


}
