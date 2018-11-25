<?php
namespace OmegaPlugin\Html;

use Omega\Utils\Plugin\FController;

class FControllerHtml extends  FController {

    public function __construct() {
        parent::__construct('html');
    }

    public function registerDependencies()
    {
        return [
            'css' => [
            ],
            'js' => [

            ]
        ];
    }

    public function display( $args, $data ) {
        return $this->view('display')->with($data);
    }
}