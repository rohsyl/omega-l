<?php
namespace OmegaPlugin\TextAndImage;

use Omega\Utils\Plugin\BController;

class BControllerTextAndImage extends  BController {

    public function __construct() {
        parent::__construct('text_and_image');
    }

    public function install() {
        parent::runSql($this->root . '/sql/install.sql');
        return true;
    }

    public function index() {
        return $this->view('index');
    }
}