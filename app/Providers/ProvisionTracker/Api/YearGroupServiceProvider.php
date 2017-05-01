<?php

namespace App\Providers\ProvisionTracker\Api;

use Illuminate\Support\ServiceProvider;
use App\Providers\ProvisionTracker\Api\YearGroupService;
use App\Providers\ProvisionTracker\UniqueIdService;

class YearGroupServiceProvider extends ServiceProvider
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
        $this->app->singleton('App\Providers\ProvisionTracker\Api\YearGroupServiceInterface', function ($app)
        {
            return new YearGroupService( new UniqueIdService() );
        });
    }
}
