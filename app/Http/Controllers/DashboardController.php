<?php

namespace Omega\Http\Controllers;

use Illuminate\Http\Request;
use Omega\Repositories\StatsRepositories;

class DashboardController extends AdminController
{
    private $statRepo;

    public function __construct(StatsRepositories $statRepo) {
        $this->statRepo = $statRepo;
    }

    public function index(){

        $data = [
            'stats' => $this->statRepo->getAllStats()
        ];

        return view('dashboard.index', $data);
    }
}
