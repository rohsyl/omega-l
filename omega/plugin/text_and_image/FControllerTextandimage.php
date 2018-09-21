<?php
namespace Omega\Plugin\Textandimage;

use Omega\Library\Plugin\FController;
use Omega\Library\Entity\Page;

class FControllerTextandimage extends  FController {


    public function __construct() {
        parent::__construct('textandimage');
    }

    public function registerDependencies()
    {
        return array(
            'css' => array(
                'assets/bootstrap_composant/css/bootstrap-grid.min.css'
            ),
            'js' => array(
            )
        );
    }

    public function display($args , $data) {
        return $this->view( $data );
    }
}