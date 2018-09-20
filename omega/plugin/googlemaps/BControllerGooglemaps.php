<?php
namespace Omega\Plugin\Googlemaps;

use Omega\Library\BLL\ModuleManager;
use Omega\Library\DTO\Module;
use Omega\Library\Plugin\BController;
use Omega\Library\Util\Config;
use Omega\Library\Util\Form;
use Omega\Library\Util\Redirect;
use Omega\Library\Util\Message;

class BControllerGooglemaps extends  BController {

    public function __construct() {
        parent::__construct('googlemaps');

    }

    public function install() {
        if (!$this->isInstalled()) {
            parent::install();
            parent::runSql($this->root . '/sql/install.sql');
        }
    }

    public function index() {

        $form = new Form('googlemaps_form');
        if($form->isPosted()) {
            if($form->checkTokenInput()){

                $apiKey = $form->getValue('apikey');
                $mapstyle = $form->getValue('mapstyle');

                Config::set('googlemaps_apikey', $apiKey);
                Config::set('googlemaps_mapstyle', $mapstyle);


                Message::success("Updated !");
                Redirect::toLastPage();
            }
        }

        $apikey = Config::get('googlemaps_apikey');
        $mapstyle = Config::get('googlemaps_mapstyle');

        $m['apikey'] = isset($apikey) ? $apikey : '';
        $m['mapstyle'] = isset($mapstyle) ? $mapstyle : '';
        return $this->view( $m );
    }

}