<?php

namespace App\Providers\ProvisionTracker\Api;

use App\Providers\ProvisionTracker\Api\StudentService;
use Illuminate\Support\ServiceProvider;
use App\Providers\ProvisionTracker\UniqueIdService;

class StudentServiceProvider extends ServiceProvider
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
        $this->app->singleton('App\Providers\ProvisionTracker\Api\StudentServiceInterface', function ($app)
        {
            return new StudentService( new UniqueIdService() );
        });
    }
}
