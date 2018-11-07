<?php
namespace OmegaPlugin\TextAndImage;

use Omega\Utils\Plugin\FController;

class FControllerTextAndImage extends  FController {

    public function __construct() {
        parent::__construct('text_and_image');
    }

    public function registerDependencies()
    {
        return [
            'css' => [
                $this->asset('css/styles.css')
            ],
            'js' => []
        ];
    }

    public function display($args , $data) {
        return $this->view('display')->with($data);
    }
}