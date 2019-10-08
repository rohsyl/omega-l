<?php

namespace Omega\Http\Controllers\Api\Component;

use Illuminate\Http\Request;
use Omega\Facades\Plugin;
use Omega\Http\Controllers\Controller;
use Omega\Http\Resources\Component\ComponentCreatable;

class ComponentCreateController extends Controller
{
    public function index() {
        return ComponentCreatable::collection(Plugin::components());
    }
}
