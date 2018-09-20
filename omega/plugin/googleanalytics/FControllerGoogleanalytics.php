<?php
namespace Omega\Plugin\Googleanalytics;

use Omega\Library\Plugin\FController;

class FControllerGoogleanalytics extends  FController {

    public function __construct() {
        parent::__construct('googleanalytics');
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

    public function display( $param, $data ) {

        $m['enabledAnalytics'] = isset($param['enable']) ? $param['enable'] : true;
        $m['id'] = isset($param['id']) ? $param['id'] : '';

        return $this->view( $m );
    }
}