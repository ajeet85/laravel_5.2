<?php

namespace App\Providers\ProvisionTracker\Api;

use Illuminate\Support\ServiceProvider;
use App\Providers\ProvisionTracker\Api\RegistrationService;
use App\Providers\ProvisionTracker\UniqueIdService;

class RegistrationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Providers\ProvisionTracker\Api\RegistrationServiceInterface', function ($app)
        {
            return new RegistrationService( new UniqueIdService(),
                                            new AccountService(),
                                            new UserService() );
        });
    }
}
