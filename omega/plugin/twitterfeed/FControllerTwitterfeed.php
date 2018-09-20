<?php
/*
 *  Generated with omega-cli.
 *  Date : lundi, 23 juillet 2018
 */

namespace Omega\Plugin\Twitterfeed;

use Omega\Library\Plugin\FController;

class FControllerTwitterfeed extends  FController {


    public function __construct() {
        parent::__construct('twitterfeed');
    }

    public function registerDependencies() {
        return array(
            'css' => array(
            ),
            'js' => array(
            )
        );
    }

    public function display( $args, $data ) {
        return $this->view();
    }
}