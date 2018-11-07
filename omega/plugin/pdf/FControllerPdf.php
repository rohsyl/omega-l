<?php
namespace OmegaPlugin\Pdf;

use Omega\Utils\Plugin\FController;

class FControllerPdf extends  FController {

    public function __construct() {
        parent::__construct('pdf');
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
        return $this->view('display')->with( $data );
    }
}