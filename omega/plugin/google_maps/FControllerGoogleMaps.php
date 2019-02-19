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
        $m['itineraryEnabled'] = isset($data['mapItineraryButtonEnabled']) ? $data['mapItineraryButtonEnabled']['itineraryButton'] : false;
        $m['lat'] = $data['lat'];
        $m['long'] = $data['long'];
        $m['zoom'] = isset($data['zoom']) && !empty($data['zoom']) && is_numeric($data['zoom']) ? $data['zoom'] : 10;
        $m['markerPicture'] = isset($data['markerPicture']) && $data['markerPicture']->id == null ? null : $data['markerPicture'];
        $m['markerText'] = $data['markerText'];
        return $this->view('display')->with($m);
    }
}