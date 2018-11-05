<?php
namespace OmegaPlugin\Text;

use Omega\Utils\Plugin\FController;

class FControllerText extends  FController {

    public function __construct() {
        parent::__construct('text');
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