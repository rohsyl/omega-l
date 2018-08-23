<?php

namespace Omega\Http\Controllers;

use Illuminate\Support\Facades\Response;

class LanguageController extends AdminController
{
    public function set(){
        /* TODO change lange
        if(isset($_GET['lang'])) {
            $_SESSION['lang'] = $_GET['lang'];
            Redirect::toLastPage();
        }*/
    }

    public function loadforjs(){

        /* TODO : js lang

         $currentlang = $_SESSION['lang'];
        $path = Path::Combine(ASSETSPATH, 'i18n', 'backoffice', 'js', $currentlang . '.json');

        if(file_exists($path))
            $trads = file_get_contents($path);
        */
        $trads = '{}';

        return Response::view('language.loadforjs', compact('trads'))
            ->header('Content-Type', 'application/javascript');
    }
}
