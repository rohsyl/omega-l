<?php

namespace Omega\Http\Controllers;

use Illuminate\Http\Request;
use Omega\Repositories\StatsRepository;

class DashboardController extends AdminController
{
    private $statRepo;

    public function __construct(StatsRepository $statRepo) {
        parent::__construct();
        $this->statRepo = $statRepo;
    }

    public function index(){

        $data = [
            'stats' => $this->statRepo->getAllStats()
        ];

        return view('dashboard.index', $data);
    }
}
