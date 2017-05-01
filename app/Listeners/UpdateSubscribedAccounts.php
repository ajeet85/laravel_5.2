<?php

namespace App\Listeners;

use App\Events\NewDayHasStarted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Providers\ProvisionTracker\Api\AccountServiceInterface;

class UpdateSubscribedAccounts
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
     * @param  NewDayHasStarted  $event
     * @return void
     */
    public function handle(NewDayHasStarted $event)
    {
        $this->accountService->decrementPackageDays( 1 );
    }
}
