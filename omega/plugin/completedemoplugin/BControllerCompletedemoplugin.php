<?php
namespace Omega\Plugin\Completedemoplugin;

use Omega\Library\Plugin\BController;

class BControllerCompletedemoplugin extends BController {

    public function __construct() {
        parent::__construct('completedemoplugin');
    }

    public function install() {
        if (!$this->isInstalled()) {
            parent::install();
            parent::runSql($this->root . DS . 'sql/install.sql');
        }
    }

    public function uninstall()
    {
        if ($this->isInstalled()) {
            parent::uninstall();
            parent::runSql($this->root . DS . 'sql/uninstall.sql');
        }
    }

    public function index() {
        $m['titre'] = "TITRE!";
        return $this->view($m);
    }

}