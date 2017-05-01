<?php

namespace App\Listeners;

use App\Events\AccountRenewalWasRequested;
use App\Events\AccountWasRenewed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Providers\ProvisionTracker\Api\AccountServiceInterface;
use Carbon\Carbon;
class RenewAccount
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct( AccountServiceInterface $accountService) {
        $this->accountService = $accountService;
    }

    /**
     * Handle the event.
     *
     * @param  AccountRenewalWasRequested  $event
     * @return void
     */
    public function handle(AccountRenewalWasRequested $event) {
        $code = $event->action_code;
        $action = $this->accountService->getAccountAction( $code );
        $account = $this->accountService->getAccount( $action->account_id );
        $this->accountService->updateActionStatus($action->id, 'actioned');
        $this->accountService->setAccountStatus( $account, 'active');
        $this->accountService->resetPackageDays( $action->account_id, 365);
        $this->accountService->setRenewedState( $action->account_id, 1 );
        $this->accountService->updateRenewalDate( $action->account_id,  Carbon::now()->addYear() );

        \Event::fire( new AccountWasRenewed( $account ) );
    }
}
