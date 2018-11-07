<?php
namespace OmegaPlugin\Gallery;


use Omega\Utils\Plugin\BController;

class BControllerGallery extends  BController {

    public function __construct(){
        parent::__construct('gallery');
    }

    public function install() {
        parent::runSql($this->root . '/sql/install.sql');
        return true;
    }

    public function index() {
        return $this->meta_view();
    }

}