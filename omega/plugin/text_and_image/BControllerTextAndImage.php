<?php
namespace OmegaPlugin\TextAndImage;

use Omega\Utils\Plugin\BController;
use OmegaPlugin\TextAndImage\FormRenderer\TextAndImageFormRenderer;

class BControllerTextAndImage extends  BController {

    public function __construct() {
        parent::__construct('text_and_image');
        $this->setComponentFormRenderer(new TextAndImageFormRenderer());
    }

    public function install() {
        parent::runSql($this->root . '/sql/install.sql');
        return true;
    }

    public function index() {
        return $this->meta_view();
    }
}