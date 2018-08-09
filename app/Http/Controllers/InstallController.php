<?php

namespace Omega\Http\Controllers;

use Illuminate\Http\Request;

class InstallController extends Controller
{

    public function index(){
        return view('install.index');
    }

    public function step1(){
        // get form date and save to session

        return redirect(route('install.siteanduser'));
    }

    public function siteanduser(){
        return view('install.siteanduser');
    }

    public function step2(){
        // get form date and save to session

        return redirect(route('install.launch'));
    }

    public function launch(){
        return view('install.launch');
    }

    public function do(){
        // install process

        return redirect(route('install.finished'));
    }

    public function finished(){
        return view('install.finished');
    }
}
