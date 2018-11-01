<?php

namespace Omega\Http\Controllers;

use Omega\Utils\Entity\Entity;
use Omega\Utils\Entity\Site;

class PublicController extends Controller
{

    public function __construct() {
        Entity::SetSite(new Site());
    }

    public function home($lang = null)
    {
        return page()->withLang($lang);
    }


}
