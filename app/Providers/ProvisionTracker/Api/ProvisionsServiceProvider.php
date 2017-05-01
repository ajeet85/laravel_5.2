<?php

namespace App\Providers\ProvisionTracker\Api;

use Illuminate\Support\ServiceProvider;
use App\Providers\ProvisionTracker\Api\ProvisionService;
use App\Providers\ProvisionTracker\UniqueIdService; 

class ProvisionsServiceProvider extends ServiceProvider
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
        $this->app->singleton('App\Providers\ProvisionTracker\Api\ProvisionServiceInterface', function ($app)
        {
            return new ProvisionService( new UniqueIdService() );
        });
    }
}
