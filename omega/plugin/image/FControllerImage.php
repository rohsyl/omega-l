<?php
namespace OmegaPlugin\Image;

use Omega\Utils\Plugin\FController;

class FControllerImage extends  FController {


    public function __construct() {
        parent::__construct('image');
    }

    public function registerDependencies()
    {
        return [
            'css' => [
                $this->asset('css/style.css')
            ],
            'js' => [
                $this->asset('js/parallax.min.js')
            ]
        ];
    }

    public function display( $args, $data) {
        //$placement = isset($args['placement']) ? $args['placement'] : 'content';
        return $this->view('display')->with($data);
    }
}