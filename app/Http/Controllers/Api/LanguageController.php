<?php

namespace Omega\Http\Controllers\Api;

use Illuminate\Http\Request;
use Omega\Http\Controllers\Controller;
use Omega\Http\Resources\LangResource;
use Omega\Repositories\LangRepository;

class LanguageController extends Controller
{
    private $langRepository;

    public function __construct(LangRepository $langRepository) {
        $this->middleware('auth:api');
        $this->langRepository = $langRepository;
    }

    public function index() {
        return LangResource::collection($this->langRepository->all());
    }
}
