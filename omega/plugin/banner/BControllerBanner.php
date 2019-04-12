<?php
namespace OmegaPlugin\Banner;

use Omega\Utils\Plugin\BController;

class BControllerBanner extends  BController {

    public function __construct() {
        parent::__construct('banner');
    }

    public function install() {
        $this->migrate();
        return true;
    }

    public function uninstall() {
        $this->reset();
        return true;
    }

    public function index() {
        return $this->meta_view();
    }
}