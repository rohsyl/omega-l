<?php
namespace OmegaPlugin\DividedContent;

use Omega\Utils\Plugin\BController;

class BControllerDividedContent extends  BController {


    public function __construct() {
        parent::__construct('divided_content');
    }

    public function install() {
        parent::runSql($this->root . '/sql/install.sql');
        return true;
    }

    public function index() {
        return $this->meta_view();
    }
}