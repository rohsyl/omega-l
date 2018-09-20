<?php
namespace Omega\Plugin\Teaser;

use Omega\Library\Plugin\BController;
use Omega\Library\Util\Redirect;

class BControllerTeaser extends  BController {


    public function __construct() {
        parent::__construct('teaser');
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