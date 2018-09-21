<?php
namespace Omega\Plugin\Sociallogo;

use Omega\Library\Plugin\FController;

class FControllerSociallogo extends  FController {

    private $socialNetwork;

    public function __construct() {
        parent::__construct('sociallogo');
        $this->socialNetwork = json_decode(file_get_contents($this->root . DS . 'socialnetworklist.json'), true);
    }

    public function registerDependencies()
    {
        return array(
            'css' => array(
                'assets/css/font-awesome.min.css',
                'plugin/sociallogo/css/style.css'
            ),
            'js' => array(
            )
        );
    }

    public function display( $userParam, $data ) {

        $m['moduleParam'] = $userParam;
        $m['title'] = isset($userParam['title']) ? $userParam['title'] : '';
        $m['socialNetworks'] = $this->socialNetwork;

        return $this->view( $m );
    }
}