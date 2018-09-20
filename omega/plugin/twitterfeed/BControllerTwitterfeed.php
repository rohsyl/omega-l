<?php
/*
 *  Generated with omega-cli.
 *  Date : lundi, 23 juillet 2018
 */

namespace Omega\Plugin\Twitterfeed;

use Omega\Library\Plugin\BController;

class BControllerTwitterfeed extends BController {

    public function __construct() {
        parent::__construct('twitterfeed');
    }

    public function install() {
        if (!$this->isInstalled()) {
            parent::install();
            parent::runSql($this->root. '/sql/install.sql');
        }
    }

    public function uninstall() {
        if ($this->isInstalled()) {
            parent::uninstall();
            parent::runSql($this->root. '/sql/uninstall.sql');
        }
    }

    public function index()
    {
        return $this->view();
    }
}