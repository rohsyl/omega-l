<?php
namespace Omega\Plugin\Features;

use Omega\Library\Plugin\FController;

define('FEATURE_USE_IMAGE', 0);
define('FEATURE_USE_ICON', 1);

class FControllerFeatures extends  FController {


    public function __construct() {
        parent::__construct('features');
    }

    public function registerDependencies()
    {
        return array(
            'css' => array(
                'plugin/features/css/style.css',
            ),
            'js' => array(
            )
        );
    }

    public function display( $args, $data ) {
        return $this->view( $data );
    }
}