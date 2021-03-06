<?php

namespace App\Providers\ProvisionTracker\Api;

use Illuminate\Support\ServiceProvider;
use App\Providers\ProvisionTracker\Api\ResourceService;
use App\Providers\ProvisionTracker\UniqueIdService;

class ResourceServiceProvider extends ServiceProvider
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
        //
        $this->app->singleton('App\Providers\ProvisionTracker\Api\ResourceServiceInterface', function ($app)
        {
            return new ResourceService( new UniqueIdService() );
        });
    }
}
