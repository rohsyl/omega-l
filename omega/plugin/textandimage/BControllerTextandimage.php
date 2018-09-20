<?php
namespace Omega\Plugin\Textandimage;

use Omega\Library\Plugin\BController;
use Omega\Library\Util\Redirect;

class BControllerTextandimage extends  BController {

    public function __construct() {
        parent::__construct('textandimage');
    }

    public function install() {
        if (!$this->isInstalled()) {
            parent::install();
            parent::runSql($this->root . '/sql/install.sql');
        }
    }

    public function index() {
            return 'Nothing to do here.';
    }
}