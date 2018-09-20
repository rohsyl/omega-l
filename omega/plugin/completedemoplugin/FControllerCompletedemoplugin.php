<?php
namespace Omega\Plugin\Completedemoplugin;

use Omega\Library\Plugin\FController;
use Omega\Library\Util\Util;

class FControllerCompletedemoplugin extends FController {

    public function __construct() {
        parent::__construct('completedemoplugin');
    }

    public function registerDependencies()
    {
        return array(
            'css' => array(
            ),
            'js' => array(
            )
        );
    }

    public function display( $args, $data ) {
        return $this->view($data);
    }

}