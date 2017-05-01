<?php

namespace App\Providers\ProvisionTracker\Api;

use Illuminate\Support\ServiceProvider;
use App\Providers\ProvisionTracker\Api\OrganisationService;
use App\Providers\ProvisionTracker\UniqueIdService;

class OrganisationServiceProvider extends ServiceProvider
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
        $this->app->singleton('App\Providers\ProvisionTracker\Api\OrganisationServiceInterface', function ($app)
        {
            return new OrganisationService( new UniqueIdService() );
        });
    }
}
