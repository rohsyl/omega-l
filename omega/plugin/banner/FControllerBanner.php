<?php
namespace OmegaPlugin\Banner;

use Omega\Utils\Plugin\FController;

class FControllerBanner extends  FController {

    public function __construct() {
        parent::__construct('banner');
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