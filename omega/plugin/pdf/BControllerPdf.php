<?php
namespace OmegaPlugin\Pdf;


use Omega\Utils\Plugin\BController;

class BControllerPdf extends  BController {
    public function __construct() {
        parent::__construct('pdf');
    }

    public function install() {
        parent::runSql($this->root . '/sql/install.sql');
        return true;
    }

    public function index() {
        return $this->meta_view();
    }
}