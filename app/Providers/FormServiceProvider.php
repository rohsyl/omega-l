<?php

namespace Omega\Providers;

use Form;
use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Form::component('omdate', 'components.form.date', ['name', 'value' => null, 'attributes' => []]);
        Form::component('omtime', 'components.form.time', ['name', 'value' => null, 'attributes' => []]);
        Form::component('omdatetime', 'components.form.datetime', ['name', 'value' => null, 'attributes' => []]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }
}
