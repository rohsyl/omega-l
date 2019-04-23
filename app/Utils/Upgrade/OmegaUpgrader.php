<?php
namespace Omega\Utils\Upgrade;

use Closure;

/**
 * Class OmegaUpgrader
 * @package Omega\Utils\Upgrade
 */
class OmegaUpgrader
{
    private static $scriptsPath;
    private static $scriptNamePattern = '*v*.php';


    public static function upgrade($currentVersion, $lastVersion) {
        self::$scriptsPath = base_path('update/scripts');

        $scripts = self::getScripts();


        $results = [];
        foreach ($scripts as $script) {
            $upgrader = include($script);
            if(version_compare($currentVersion, $upgrader->getVersion(), '<')) {
                $result = $upgrader->run();
                $results[] = $result;
                if ($result->hasFailed()) {
                    break;
                }
            }
        }

        print_r($results);

        return true;
    }

    /**
     * @return OmegaUpgrader[]
     */
    private static function getScripts() {
        return glob(self::$scriptsPath . '/' . self::$scriptNamePattern);
    }

    /**
     * Get an instance of omegaupdater for the given version
     *
     * @param $version string The version
     * @return OmegaUpgrader
     */
    public static function toVersion($version) {
        return new self($version);
    }


    private $version;
    private $postUpgradeFunction;

    private function __construct($version) {
        $this->version = $version;
    }

    public function getVersion() {
        return $this->version;
    }

    public function postUpgrade(Closure $closure) {
        $this->postUpgradeFunction = $closure;
        return $this;
    }

    /**
     * @return ScriptResult
     */
    protected function run() {
        $r = new ScriptResult();
        return call_user_func($this->postUpgradeFunction, $r);
    }
}