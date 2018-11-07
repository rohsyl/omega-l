<?php
namespace OmegaPlugin\Title;

use Omega\Utils\Plugin\FController;

class FControllerTitle extends  FController {

    public function __construct() {
        parent::__construct('title');
    }

    public function registerDependencies()
    {
        return [
            'css' => [
                $this->asset('css/styles.css')
            ],
            'js' => [

            ]
        ];
    }

    public function display( $args, $data ) {
        return $this->view('display')->with($data);
    }
}