<?php

namespace Omega\Http\Controllers\Api\Page;

use Illuminate\Http\Request;
use Omega\Http\Controllers\Controller;

class PageEditController extends Controller
{

    public function __construct() {
        $this->middleware('auth:api');
    }


}