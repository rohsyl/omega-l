<?php
namespace OmegaPlugin\Title;

use Omega\Utils\Plugin\BController;

class BControllerTitle extends  BController {

    public function __construct() {
        parent::__construct('title');
    }

    public function install() {
        $this->runSql($this->root . '/sql/install.sql');
        return true;
    }

    public function index() {
        return $this->meta_view();
    }
}