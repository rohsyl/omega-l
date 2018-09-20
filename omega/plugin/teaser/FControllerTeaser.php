<?php
namespace Omega\Plugin\Teaser;

use Omega\Library\Plugin\FController;
use Omega\Library\Util\Util;

class FControllerTeaser extends  FController {


    public function __construct() {
        parent::__construct('teaser');
    }

    public function registerDependencies()
    {
        return array(
            'css' => array(
                'plugin/teaser/css/style.css'
            ),
            'js' => array(
            )
        );
    }

    public function display( $args, $data ) {
        return $this->view( $data );
    }
}