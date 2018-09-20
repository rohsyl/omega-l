<?php
namespace Omega\Plugin\Facebookfeed;

use Omega\Library\Util\Config;
use Omega\Library\Plugin\FController;
use Omega\Plugin\Facebookfeed\Library\FacebookFeedApi;

class FControllerFacebookfeed extends  FController {


    const DEFAULT_NB_POST = 5;

    public function __construct() {
        parent::__construct('facebookfeed');
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

    public function display( $args, $data ) {

        $success = true;
        $message = '';

        $apikey = Config::get('facebookfeed_apikey');

        $idfbpage = isset($data['îdfbpage']) ? $data['îdfbpage'] : '';
        $nbpost = isset($data['nbpost']) ? $data['nbpost'] : self::DEFAULT_NB_POST;

        if(isset($apikey)) {
            $fbapi = new FacebookFeedApi(Config::get('facebookfeed_apikey'));


        }
        else {
            $success = false;
            $message = 'No API Key...';
        }


        $m['success'] = $success;
        $m['message'] = $message;
        return $this->view();
    }

}