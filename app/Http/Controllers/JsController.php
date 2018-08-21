<?php
namespace Omega\Http\Controllers;

use Illuminate\Support\Facades\Response;

class JsController extends AdminController
{
    public function loadmain(){
        return Response::view('js.main')
            ->header('Content-Type', 'application/javascript');
    }
}
