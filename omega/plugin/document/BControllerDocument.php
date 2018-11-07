<?php
namespace OmegaPlugin\Document;

use Omega\Utils\Plugin\BController;

class BControllerDocument extends  BController {

    public function __construct(){
        parent::__construct('document');
        //$this->includeFile('library.php');
    }

    public function install() {
        parent::runSql($this->root . '/sql/install.sql');
        return true;
    }

    public function index() {
        return $this->meta_view();
    }

}