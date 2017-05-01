<?php

namespace App\Providers\ProvisionTracker\Api;

use Illuminate\Support\ServiceProvider;
use App\Providers\ProvisionTracker\UniqueIdService;
use App\Providers\ProvisionTracker\Api\SubjectsService;

class SubjectsServiceProvider extends ServiceProvider
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
        $this->app->singleton('App\Providers\ProvisionTracker\Api\SubjectsServiceInterface', function ($app)
        {
            return new SubjectsService( new UniqueIdService() );
        });
    }
}
