<?php

namespace App\Providers\ProvisionTracker\Api;

use Illuminate\Support\ServiceProvider;
use App\Providers\ProvisionTracker\UniqueIdService;

class AreaOfNeedServiceProvider extends ServiceProvider
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
         $this->app->singleton('App\Providers\ProvisionTracker\Api\AreaOfNeedServiceInterface', function ($app)
        {
            return new AreaOfNeedService( new UniqueIdService() );
        });
    }
}
