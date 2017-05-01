<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        //

        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        // $this->mapWebRoutes($router);
        $router->group(['namespace' => $this->namespace, 'middleware' => 'web'], function ($router) {
            //-------------------------------------
            // Access
            require app_path('Http/Routes/access.php');
            //-------------------------------------
            // Actions
            require app_path('Http/Routes/actions.php');
            //-------------------------------------
            // Suppliers / Vendors / 3rd Party
            // require app_path('Http/Routes/suppliers/groupcall.php');
            require app_path('Http/Routes/suppliers/wonde.php');
            //-------------------------------------
            // Dashboard
            require app_path('Http/Routes/dashboard.php');
            //-------------------------------------
            // Organisations
            require app_path('Http/Routes/organisations/organisations.php');
            require app_path('Http/Routes/organisations/datasources.php');
            require app_path('Http/Routes/organisations/termdates.php');
            require app_path('Http/Routes/organisations/teachers.php');
            require app_path('Http/Routes/organisations/pupils.php');
            require app_path('Http/Routes/organisations/classes.php');
            require app_path('Http/Routes/organisations/assessments.php');
            require app_path('Http/Routes/organisations/vulnerbale-groups.php');
            require app_path('Http/Routes/organisations/needs.php');
            //-------------------------------------
            // Manage
            require app_path('Http/Routes/manage/provisions.php');
            require app_path('Http/Routes/manage/timeslots.php');
            require app_path('Http/Routes/manage/resources-digital.php');
            require app_path('Http/Routes/manage/resources-location.php');
            require app_path('Http/Routes/manage/resources-physical.php');
            require app_path('Http/Routes/manage/resources-providers.php');
            //-------------------------------------
            // Scheduling
            require app_path('Http/Routes/schedule/schedule.php');
            //-------------------------------------
            // Reporting
            require app_path('Http/Routes/reporting/reporting.php');
            //-------------------------------------
            // Settings
            require app_path('Http/Routes/settings/settings.php');
            require app_path('Http/Routes/settings/users.php');
            require app_path('Http/Routes/settings/profile.php');
            require app_path('Http/Routes/settings/notifications.php');
        });
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    protected function mapWebRoutes(Router $router)
    {
        $router->group([
            'namespace' => $this->namespace, 'middleware' => 'web',
        ], function ($router) {
            require app_path('Http/routes.php');
        });
    }
}
