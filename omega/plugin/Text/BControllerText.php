<?php
namespace OmegaPlugin\Text;


use Omega\Utils\Plugin\BController;

class BControllerText extends  BController {


    public function __construct() {
        parent::__construct('text');
    }

    public function install() {
        if (!$this->isInstalled()) {
            $this->runSql($this->root . '/sql/install.sql');
        }
    }

    public function index() {
        return 'Nothing to do here.';
    }
}