<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\UserWasRegistered' => [
            'App\Listeners\RequestRegistrationConfirmation',
            'App\Listeners\NotifyTeamOfRegistration',
        ],

        'App\Events\RegistrationWasConfirmed' => [
            'App\Listeners\StartTrialPeriod'
        ],

        'App\Events\NewDayHasStarted' => [
            'App\Listeners\UpdateTrialPeriod',
            'App\Listeners\UpdateSubscribedAccounts'
        ],

        'App\Events\NewMonthHasStarted' => [

        ],

        'App\Events\PackageSubscriptionHasFinished' => [
            'App\Listeners\NotifyTeamOfCompletedSubscription',
            'App\Listeners\NotifyUserOfCompletedSubscription',
        ],

        'App\Events\TrialPeriodHasFinished' => [
            'App\Listeners\NotifyTeamOfCompletedTrial',
            'App\Listeners\NotifyUserOfCompletedTrial'
        ],

        'App\Events\AccountRenewalWasRequested' => [
            'App\Listeners\RenewAccount'
        ],

        'App\Events\AccountWasRenewed' => [
            'App\Listeners\RaiseNewInvoice',
            'App\Listeners\NotifyTeamOfRenewal',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
