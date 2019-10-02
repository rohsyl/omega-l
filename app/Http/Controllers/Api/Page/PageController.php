<?php

namespace Omega\Http\Controllers\Api\Page;

use Illuminate\Http\Request;
use Omega\Http\Controllers\Controller;
use Omega\Http\Resources\PageEditResource;
use Omega\Http\Resources\PageResource;
use Omega\Models\Page;
use Omega\Repositories\PageRepository;

class PageController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }

    public function index(int $ignore = null) {

        $query = Page::query();

        if(isset($ignore)) {
            $query->where('id', '!=', $ignore);
        }

        return PageResource::collection($query->get());
    }

    public function edit(int $id) {
        return new PageEditResource(Page::find($id));
    }
}
