<?php

namespace Omega\Providers;

use Collective\Html\FormFacade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Omega\Facades\OmegaUtils;
use Omega\Utils\Path;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        FormFacade::component('omMediaChooser', 'components.form.mediachooser', ['name', 'label', 'value' => null, 'attributes' => []]);

        if(!OmegaUtils::isInstalled()){
            return;
        }

        $currentThemeName = om_config('om_theme_name');
        // Add a namespace to access theme views
        View::addNamespace('theme', theme_path($currentThemeName));

        // register publish current theme assets
        $this->publishes([
            Path::Combine(theme_path($currentThemeName), 'assets') => public_path('theme'),
        ], 'theme');


        // register each plugin assets to allow them to be publised
        $pluginsAssets = [];
        foreach(OmegaUtils::getInstalledPlugin() as $plugin){
            $pluginName = $plugin->name;
            $src = Path::Combine(plugin_path($pluginName), 'assets');
            $dest = public_path('plugin/'.$pluginName);
            $pluginsAssets[$src] = $dest;

            $this->publishes([
                $src => $dest,
            ], 'plugin:'.$pluginName);
        }

        // register all plugin in one group for mass publishing
        $this->publishes($pluginsAssets, 'plugins');

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
