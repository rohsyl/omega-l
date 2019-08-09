<?php
namespace rohsyl\OmegaPlugin\Menu\Http\Controllers;

use Omega\Utils\Plugin\Package\BControllerPackage;

class BController extends BControllerPackage
{
    public function __construct() {
        parent::__construct('menu');
    }

    public function index() {
        return view('plugin_menu::index');
    }

    public function install() {
        $this->migrate();
        return true;
    }

    public function uninstall() {
        $this->reset();
        return true;
    }
}