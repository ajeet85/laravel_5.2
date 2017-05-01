<?php

namespace App\Listeners;

use App\Events\AccountWasRenewed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Providers\Billing\InvoiceServiceInterface;
use App\Providers\ProvisionTracker\Api\AccountServiceInterface;
use App\Providers\ProvisionTracker\Api\UserServiceInterface;

class RaiseNewInvoice
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct( InvoiceServiceInterface $invoiceService,
                                 UserServiceInterface $userService,
                                 AccountServiceInterface $accountService) {
        $this->invoiceService = $invoiceService;
        $this->accountService = $accountService;
        $this->userService = $userService;
    }

    /**
     * Handle the event.
     *
     * @param  AccountWasRenewed  $event
     * @return void
     */
    public function handle(AccountWasRenewed $event) {
        $invoice = $this->invoiceService->raiseInvoice( $event->account );
        $pdf = $this->invoiceService->createInvoicePdf($invoice->invoice_number, $event->account->id);
        $user = $this->userService->getUser( null, $event->account->manager_id );

        \Mail::queue(['html'=>'emails.account.invoice'],
        ['account'=>$event->account, 'user'=> $user],
        function( $message ) use ($user, $invoice, $pdf) {
            $message->subject("Provision Tracker Invoice: $invoice->invoice_number");
            $message->from(config('mail.from')['address'], config('mail.from')['name']);
            $message->to($user->email, "$user->first_name $user->last_name");
            $message->attach($pdf);
        });
    }
}
