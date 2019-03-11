<?php

namespace Omega\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Omega\Policies\OmegaGate;
use Omega\Utils\Member\MemberUserProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'Omega\Model' => 'Omega\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
        OmegaGate::define();

        Auth::provider('omega_member', function ($app, array $config){
            return new MemberUserProvider();
        });
    }
}
