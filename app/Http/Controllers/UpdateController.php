<?php

namespace Omega\Http\Controllers;

use Illuminate\Http\Request;

class UpdateController extends AdminController
{

    public function check() {
        return view('update.check');
    }
}
