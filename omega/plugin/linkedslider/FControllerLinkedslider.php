<?php
namespace Omega\Plugin\LinkedSlider;

use Omega\Library\Plugin\FController;

class ControllerLinkedslider_Front extends  FController {


    public function __construct() {
        parent::__construct('linkedSlider');
    }

    public function registerDependencies()
    {
        return array(
            'css' => array(
                'plugin/linkedSlider/css/styles.css'
            ),
            'js' => array(
            )
        );
    }

    public function display( $args ) {

        $hasVideo = false;
        foreach($args['slides'] as $slide){
            if($slide['type'] == 'video'){
                $hasVideo = true;
            }
        }
        $args['hasVideo'] = $hasVideo;
        return $this->view( $args );
    }
}