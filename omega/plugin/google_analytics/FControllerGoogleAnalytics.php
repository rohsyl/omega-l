<?php
namespace OmegaPlugin\GoogleAnalytics;

use Omega\Utils\Plugin\FController;

class FControllerGoogleAnalytics extends  FController {

    public function __construct() {
        parent::__construct('google_analytics');
    }

    public function registerDependencies()
    {
        return [
            'css' => [
            ],
            'js' => [
            ]
        ];
    }

    public function display( $param, $data ) {

        $m['enable'] = isset($param['enable']) ? $param['enable'] : true;
        $m['id'] = isset($param['id']) ? $param['id'] : '';

        return $this->view('display')->with($m);
    }
}