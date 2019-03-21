<?php
namespace OmegaPlugin\Feature;

use Omega\Utils\Plugin\BController;

class BControllerFeature extends  BController {

    public function __construct() {
        parent::__construct('feature');
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