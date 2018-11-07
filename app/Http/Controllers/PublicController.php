<?php

namespace Omega\Http\Controllers;

use Omega\Facades\Entity;
use Omega\Facades\OmegaUtils;
use Omega\Utils\Entity\Site;

class PublicController extends Controller
{

    public function __construct() {

        if(OmegaUtils::isInstalled()){
            Entity::setSite(new Site());
        }
    }

    public function home() {
        return page();
    }

    public function home_with_lang($lang) {
        return page()->withLang($lang);
    }

    public function slug($slug) {
        return page()->withSlug($slug);
    }

    public function slug_and_lang($lang, $slug) {
        return page()->withLang($lang)->withSlug($slug);
    }


}
