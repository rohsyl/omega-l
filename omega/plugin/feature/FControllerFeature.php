<?php
namespace OmegaPlugin\Feature;

use Omega\Utils\Plugin\FController;

define('FEATURE_USE_IMAGE', 0);
define('FEATURE_USE_ICON', 1);

class FControllerFeature extends  FController {

    public function __construct() {
        parent::__construct('feature');
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