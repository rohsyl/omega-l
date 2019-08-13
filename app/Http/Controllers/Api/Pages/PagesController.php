<?php

namespace Omega\Http\Controllers\Api\Pages;

use Illuminate\Http\Request;
use Omega\Http\Controllers\Controller;
use Omega\Http\Resources\PageResource;
use Omega\Repositories\PageRepository;

class PagesController extends Controller
{

    private $pageRepository;

    public function __construct(PageRepository $pageRepository) {
        $this->middleware('auth:api');
        $this->pageRepository = $pageRepository;
    }

    public function get(int $id) {
        return new PageResource($this->pageRepository->get($id));
    }
}
