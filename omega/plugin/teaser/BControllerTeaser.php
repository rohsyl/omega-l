<?php
namespace OmegaPlugin\Teaser;

use Omega\Utils\Plugin\BController;

class BControllerTeaser extends  BController {


    public function __construct() {
        parent::__construct('teaser');
    }

    public function install() {
        parent::runSql($this->root . '/sql/install.sql');
        return true;
    }

    public function index() {
        return $this->meta_view();
    }
}