<?php
namespace rohsyl\OmegaPlugin\Menu;

use Omega\Utils\Plugin\Package\OmegaPluginServiceProvider;

class PluginServiceProvider extends OmegaPluginServiceProvider
{
    public function boot() {

        //$meta = $this->getMeta(__DIR__);

        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/lang', 'plugin_menu');
        $this->loadViewsFrom(__DIR__.'/views', 'plugin_menu');

        $this->publishes([
            __DIR__.'/config/plugin_menu.php' => config_path('plugin_menu.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/lang' => resource_path('lang/vendor/plugin_menu'),
        ], 'lang');

        $this->publishes([
            __DIR__.'/views' => resource_path('views/vendor/plugin_menu'),
        ], 'views');

        $this->publishes([
            __DIR__.'/assets' => public_path('plugin/menu'),
        ], 'public');
    }

    public function register() {

    }
}