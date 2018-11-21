<?php
namespace OmegaPlugin\LangRedirect;

use Omega\Utils\Plugin\BController;

class BControllerLangRedirect extends  BController {

    public function __construct() {
        parent::__construct('lang_redirect');
    }

    public function install() {
        $this->runSql($this->root . '/sql/install.sql');
        return true;
    }

    public function index() {
        return $this->meta_view();
    }
}