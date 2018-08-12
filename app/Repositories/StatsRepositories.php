<?php
namespace Omega\Repositories;

use Omega\Page;
use Omega\User;

class StatsRepositories{

    private $user;
    private $page;
    private $currentTheme;

    public function __construct(User $user, Page $page) {

        $this->user = $user;
        $this->page = $page;
        $this->currentTheme = om_config('om_theme_name');
    }

    public function getAllStats(){
        return [
            'page' => $this->page->count(),
            'user' => $this->user->count(),
            'theme' => $this->currentTheme,
        ];
    }
}