<?php
/**
 * Created by PhpStorm.
 * User: rmen
 * Date: 18.07.2018
 * Time: 13:20
 */

namespace Omega\Plugin\Facebookfeed\Library;


class FacebookFeedApi
{
    private $apikey;

    public function __construct($apikey){
        $this->apikey = $apikey;
    }

    public function getFeedForPage($idfbpage, $nbpost) {

        //TODO

    }

}