<?php
namespace OmegaPlugin\SocialLogo;

use Omega\Utils\Plugin\FController;

class FControllerSocialLogo extends  FController {

    private $socialNetwork;

    public function __construct() {
        parent::__construct('social_logo');
        $this->socialNetwork = json_decode(file_get_contents($this->root . DS . 'socialnetworklist.json'), true);
    }

    public function registerDependencies()
    {
        return array(
            'css' => array(
                $this->asset('css/styles.css')
            ),
            'js' => array(
            )
        );
    }

    public function display( $userParam, $data ) {

        $m['moduleParam'] = $userParam;
        $m['title'] = isset($userParam['title']) ? $userParam['title'] : '';
        $m['socialNetworks'] = $this->socialNetwork;

        return $this->view('display')->with($m);
    }
}