<?php
namespace OmegaPlugin\GoogleMaps;


use Illuminate\Support\Facades\Validator;
use Omega\Utils\Plugin\BController;

class BControllerGoogleMaps extends  BController {

    public function __construct() {
        parent::__construct('google_maps');

    }

    public function install() {
        parent::runSql($this->root . '/sql/install.sql');
        return true;
    }

    public function index() {
        return $this->view('index')->with([
            'apikey' => om_config('googlemaps_apikey'),
            'mapstyle' => om_config('googlemaps_mapstyle'),
        ]);
    }

    public function save(){
        $request = request();

        $validator = Validator::make($request->all(), [
            'apikey' => 'nullable',
            'mapstyle' => 'nullable'
        ]);

        if($validator->fails()){
            return $this->redirect('index')
                ->withErrors($validator)
                ->withInput();
        }

        om_config(['googlemaps_apikey' => $request->input('apikey')]);
        om_config(['googlemaps_mapstyle' => $request->input('mapstyle')]);

        toast()->success(__('Saved'));
        return $this->redirect('index');
    }

}