<?php

namespace Omega\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(){
        return view('settings.index');
    }
}
