<?php
namespace Omega\Plugin\Features;

use Omega\Library\Util\LinkChooser;
use Omega\Library\Plugin\BController;

class BControllerFeatures extends  BController {

    private $nbr = 3;

    public function __construct() {
        parent::__construct('features');

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