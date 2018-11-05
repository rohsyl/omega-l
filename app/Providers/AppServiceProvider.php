<?php

namespace Omega\Providers;

use Collective\Html\FormFacade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
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


        $currentThemeName = om_config('om_theme_name');

        // Add a namespace to access theme views
        View::addNamespace('theme', theme_path($currentThemeName));

        // publish current theme assets
        $this->publishes([
            Path::Combine(theme_path($currentThemeName), 'assets') => public_path('theme'),
        ], 'theme');

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
