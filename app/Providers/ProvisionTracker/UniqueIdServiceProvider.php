<?php

namespace App\Providers\ProvisionTracker;

use Illuminate\Support\ServiceProvider;

class UniqueIdServiceProvider extends ServiceProvider
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
        $this->app->singleton('App\Providers\ProvisionTracker\UniqueIdServiceInterface', function ($app)
        {
            return new UniqueIdService();
        });
    }
}
