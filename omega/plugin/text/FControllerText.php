<?php
namespace Omega\Plugin\Text;

use Omega\Library\Plugin\FController;

class FControllerText extends  FController {


    public function __construct() {
        parent::__construct('text');
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
        return $this->view( $data );
    }
}