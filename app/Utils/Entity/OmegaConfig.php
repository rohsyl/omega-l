<?php


namespace Omega\Utils\Entity;


use Omega\Models\Config;
use Omega\Models\Right;
use Omega\Models\User;

class OmegaConfig
{


    private $config = [];

    public function load(array $configKeys){
        $configs = Config::whereIn('key', $configKeys)->get();
        foreach ($configs as $config) {
            $this->config[$config->key] = $config->value;
        }
    }

    public function get(string $key){
        if(isset($this->config[$key])) {
            return $this->config[$key];
        }
        return null;
    }

    public function updateIfExists(Config $config){
        if(isset($this->config[$config->key])) {$this->config[$config->key] = $config->value;
        }
    }





    /**
     * @param $user User
     */
    public function loadUserPermissionsInSession($user){
        // load all right
        $rights = Right::all()->pluck('name');
        $max = $rights->count();
        $userMask = '';
        $rightMasks = [];
        // build masks
        foreach ($rights as $i => $right) {
            $rightMasks[$right] = $this->getMask($i, $max);
            $userMask = ( $user->hasRight($right, true) ? '1' : '0' ) . $userMask;
        }
        // save in session
        session(['perm.masks' => $rightMasks]);
        session(['perm.umask' => $userMask]);
    }


    private function getMask($i, $max) {
        $mask = '';
        for ($x = 0; $x < $max; $x++) {
            if($x == $i)
                $mask = '1' . $mask;
            else
                $mask = '0' . $mask;
        }
        return $mask;
    }
}