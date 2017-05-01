<?php

namespace App\Providers\Mis;

use Illuminate\Support\ServiceProvider;
use App\Providers\Mis\WondeService;

class WondeServiceProvider extends ServiceProvider
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
        $this->app->singleton('App\Providers\Mis\WondeServiceInterface', function ($app)
        {
            return new WondeService( );
        });
    }
}
