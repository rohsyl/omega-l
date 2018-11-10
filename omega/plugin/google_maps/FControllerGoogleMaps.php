<?php
namespace OmegaPlugin\GoogleMaps;


use Omega\Utils\Plugin\FController;

class FControllerGoogleMaps extends  FController {

    public function __construct() {
        parent::__construct('google_maps');
    }

    public function registerDependencies()
    {
        return [
            'css' => [
                $this->asset('css/styles.css'),
            ],
            'js' => [
            ]
        ];
    }

    public function display( $param, $data ) {

        $m['uid'] = $this->unique();

        $m['apikey'] = om_config('googlemaps_apikey');
        $m['mapstyle'] = om_config('googlemaps_mapstyle');
        $m['mapstyleEnabled'] = isset($data['mapstyleEnabled']) ? $data['mapstyleEnabled']['mapstyle'] : false;
        $m['lat'] = $data['lat'];
        $m['long'] = $data['long'];
        $m['markerPicture'] = $data['markerPicture']->id == null ? null : $data['markerPicture'];
        $m['markerText'] = $data['markerText'];
        return $this->view( $m );
    }
}