<?php
/**
 * Created by PhpStorm.
 * User: rohs
 * Date: 05.11.18
 * Time: 15:18
 */

namespace Omega\Providers;

use Illuminate\Support\ServiceProvider;
use Omega\Utils\Entity\ModuleArea;
use Omega\Utils\Entity\Entity;
use Omega\Utils\OmegaUtils;
use Omega\Utils\Plugin\Form\FormFactory;

class UtilsServiceProvider  extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('omega:entity', function () {
            return new Entity;
        });

        $this->app->bind('omega:modulearea', function () {
            return new ModuleArea;
        });

        $this->app->bind('omega:utils', function () {
            return new OmegaUtils;
        });


        $this->app->bind('omega:formfactory', function () {
            return new FormFactory;
        });
    }
}