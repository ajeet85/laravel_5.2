<?php

namespace App\Listeners;

use App\Events\RegistrationWasConfirmed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Providers\ProvisionTracker\Api\AccountServiceInterface;
use Carbon\Carbon;

class StartTrialPeriod
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct( AccountServiceInterface $accountService )
    {
        $this->accountService = $accountService;
    }

    /**
     * Handle the event.
     *
     * @param  RegistrationWasConfirmed  $event
     * @return void
     */
    public function handle( RegistrationWasConfirmed $event )
    {
        $account = $event->account;
        $account = $this->accountService->getAccount($account->id);
        $account->trial_start_date = Carbon::now();
        $account->trial_end_date = Carbon::now()->addDays(30);
        $account->save();
    }
}
