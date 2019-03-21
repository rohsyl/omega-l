<?php


namespace Omega\Utils\Entity;


use Omega\Models\Config;

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
}