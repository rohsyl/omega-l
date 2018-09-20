<?php
namespace Omega\Plugin\Document;

use Omega\Library\Plugin\BController;
use Omega\Library\Util\Redirect;
use function Omega\Library\array_orderby;

class BControllerDocument extends  BController {

    public function __construct(){
        parent::__construct('document');
        $this->includeFile('library.php');
    }


    public function install() {
        if (!$this->isInstalled()) {
            parent::install();
            parent::runSql($this->root . '/sql/install.sql');
        }
    }

    public function index() {
        return 'Nothing to do here...';
    }

}