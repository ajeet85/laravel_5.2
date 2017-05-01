<?php

namespace App\Providers\ProvisionTracker\Api;

use Illuminate\Support\ServiceProvider;
use App\Providers\ProvisionTracker\Api\ScheduleService;
use App\Providers\ProvisionTracker\UniqueIdService;

class ScheduleServiceProvider extends ServiceProvider
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
        $this->app->singleton('App\Providers\ProvisionTracker\Api\ScheduleServiceInterface', function ($app)
        {
            return new ScheduleService( new UniqueIdService() );
        });
    }
}
