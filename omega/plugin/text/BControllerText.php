<?php
namespace OmegaPlugin\Text;

use Omega\Utils\Plugin\BController;

class BControllerText extends  BController {

    public function __construct() {
        parent::__construct('text');
    }

    public function install() {
        $this->runSql($this->root . '/sql/install.sql');
        return true;
    }

    public function index() {
        return $this->meta_view();
    }
}