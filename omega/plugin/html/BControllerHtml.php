<?php
namespace OmegaPlugin\Html;

use Omega\Utils\Plugin\BController;

class BControllerHtml extends  BController {

    public function __construct() {
        parent::__construct('html');
    }

    public function install() {
        $this->runSql($this->root . '/sql/install.sql');
        return true;
    }

    public function index() {
        return $this->meta_view();
    }
}