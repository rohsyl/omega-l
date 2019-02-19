<?php
namespace OmegaPlugin\MultilanguePageReplicate;

use Omega\Utils\Plugin\FController;

class FControllerMultilanguePageReplicate extends  FController {

    public function __construct() {
        parent::__construct('multilangue_page_replicate');
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

    public function display( $userParam, $data ) {

        return '';
    }
}