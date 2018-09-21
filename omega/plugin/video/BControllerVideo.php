<?php
namespace OmegaPlugin\Video;

use Omega\Utils\Plugin\BController;

class BControllerVideo extends  BController {


    public function __construct() {
        parent::__construct('video');
    }

    public function install() {
        parent::runSql($this->root . '/sql/install.sql');
        return true;
    }

    public function index() {
        return $this->meta_view();
    }
}