<?php
namespace Omega\Plugin\Googlemaps;

use Omega\Library\Plugin\FController;
use Omega\Library\Util\Config;

class FControllerGooglemaps extends  FController {

    public function __construct() {
        parent::__construct('googlemaps');
    }

    public function registerDependencies()
    {
        return array(
            'css' => array(
                'plugin/googlemaps/css/style.css'
            ),
            'js' => array(
            )
        );
    }

    public function display( $param, $data ) {
        $m['uid'] = $this->name . $this->idComponent;

        $m['apikey'] = Config::get('googlemaps_apikey');
        $m['mapstyle'] = Config::get('googlemaps_mapstyle');
        $m['mapstyleEnabled'] = isset($data['mapstyleEnabled']) ? $data['mapstyleEnabled']['mapstyle'] : false;
        $m['lat'] = $data['lat'];
        $m['long'] = $data['long'];
        $m['markerPicture'] = $data['markerPicture']->id == null ? null : $data['markerPicture'];
        $m['markerText'] = $data['markerText'];
        return $this->view( $m );
    }
}