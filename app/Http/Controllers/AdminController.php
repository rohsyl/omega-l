<?php

namespace Omega\Http\Controllers;

/**
 * Class AdminController.
 * This class must be extended by all the controller that need auth middleware
 * @package Omega\Http\Controllers
 */
class AdminController extends Controller
{
    public function __construct()
    {
        // the admin controller force the auth
        $this->middleware('auth');
    }
}
