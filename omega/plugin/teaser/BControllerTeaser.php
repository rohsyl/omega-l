<?php
namespace OmegaPlugin\Teaser;

use Omega\Utils\Plugin\BController;
use OmegaPlugin\Teaser\FormRenderer\TeaserFormRenderer;

class BControllerTeaser extends  BController {


    public function __construct() {
        parent::__construct('teaser');
        $this->setModuleFormRenderer(new TeaserFormRenderer());
        $this->setComponentFormRenderer(new TeaserFormRenderer());
    }

    public function install() {
        parent::runSql($this->root . '/sql/install.sql');
        return true;
    }

    public function index() {
        return $this->meta_view();
    }
}