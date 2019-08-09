<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 15.06.19
 * Time: 16:12
 */

namespace Omega\Utils\Plugin\Package;


use Illuminate\Support\ServiceProvider;
use Omega\Utils\Plugin\PluginMeta;

abstract class OmegaPluginServiceProvider extends ServiceProvider
{
    /**
     * @return PluginMeta
     */
    public function getMeta($dir) {
        $path = $dir . '/../plugin.json';
        return new PluginMeta($path, true);
    }
}