<?php
namespace Omega\Plugin\DividedContent;

use Omega\Library\Plugin\BController;
use Omega\Library\Util\Redirect;

class BControllerDividedcontent extends  BController {


    public function __construct() {
        parent::__construct('dividedcontent');
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