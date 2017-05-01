<?php

namespace App\Providers\Billing;

use Illuminate\Support\ServiceProvider;
use App\Providers\ProvisionTracker\Api\AccountService;
use App\Providers\ProvisionTracker\UniqueIdService;

class InvoiceServiceProvider extends ServiceProvider
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
        $this->app->singleton('App\Providers\Billing\InvoiceServiceInterface', function ($app)
        {
            return new InvoiceService( $app['App\Providers\ProvisionTracker\Api\AccountService'],
                                       $app['App\Providers\ProvisionTracker\Api\PackageService'],
                                       new UniqueIdService());
        });
    }
}
