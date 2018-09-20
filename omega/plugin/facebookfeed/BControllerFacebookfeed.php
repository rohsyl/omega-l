<?php
namespace Omega\Plugin\Facebookfeed;

use Omega\Library\Util\Config;
use Omega\Library\Plugin\BController;
use Omega\Library\Util\Form;
use Omega\Library\Util\Message;
use Omega\Library\Util\Redirect;

class BControllerFacebookfeed extends  BController {


    public function __construct() {
        parent::__construct('facebookfeed');
    }

    public function install() {
        if (!$this->isInstalled()) {
            parent::install();
            parent::runSql($this->root . '/sql/install.sql');
        }
    }

    public function index() {

        $form = new Form('facebookfeed_form');
        if($form->isPosted()){
            if($form->checkTokenInput()){

                $apiKey = $form->getValue('fbapikey');
                Config::set('facebookfeed_apikey', $apiKey);

                Message::success('Api Key saved !');
                Redirect::toLastPage();

            }
        }

        $apiKey = Config::get('facebookfeed_apikey');

        $m['apikey'] = isset($apiKey) ? $apiKey : '';

        return $this->view($m);
    }


}