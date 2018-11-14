<?php

namespace Omega\Http\Controllers;

use Illuminate\Http\Request;
use Omega\Repositories\PageRepository;
use Omega\Repositories\StatsRepository;
use Omega\Repositories\UserRepository;

class DashboardController extends AdminController
{
    const LIMIT_PAGES = 7;

    private $statRepo;
    private $pageRepository;
    private $userRepository;

    public function __construct(StatsRepository $statRepo, PageRepository $pageRepository, UserRepository $userRepository) {
        parent::__construct();
        $this->statRepo = $statRepo;
        $this->pageRepository = $pageRepository;
        $this->userRepository = $userRepository;
    }

    public function index(){

        $data = [
            'stats' => $this->statRepo->getAllStats(),
            'pages' => $this->pageRepository->getLastUpdatedPages(self::LIMIT_PAGES),
            'users' => $this->userRepository->all(),
        ];

        return view('dashboard.index', $data);
    }
}
