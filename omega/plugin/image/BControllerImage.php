<?php
namespace OmegaPlugin\Image;


use Omega\Utils\Plugin\BController;

class BControllerImage extends  BController {
    public function __construct() {
        parent::__construct('image');
    }

    public function install() {
        parent::runSql($this->root . '/sql/install.sql');
        return true;
    }

    public function index() {
        return $this->meta_view();
    }
}