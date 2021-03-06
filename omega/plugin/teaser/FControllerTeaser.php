<?php
namespace OmegaPlugin\Teaser;

use Omega\Utils\Plugin\FController;

class FControllerTeaser extends  FController {


    public function __construct() {
        parent::__construct('teaser');
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
        return $this->view('display')->with( $data );
    }
}