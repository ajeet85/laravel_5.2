<?php

namespace App\Listeners;

use App\Events\AccountWasRenewed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Providers\ProvisionTracker\Api\UserServiceInterface;

class NotifyTeamOfRenewal
{
    /**
     * Create the event listener.
     *
     * @return void
     */
     public function __construct( UserServiceInterface $userService )  {
         $this->userService = $userService;
     }

    /**
     * Handle the event.
     *
     * @param  AccountWasRenewed  $event
     * @return void
     */
    public function handle(AccountWasRenewed $event) {
        $user = $this->userService->getUser( null, $event->account->manager_id );
        \Mail::queue(['html'=>'emails.team.account-renewed'],
        ['user'=>$user],
        function( $message ){
            $message->subject('Account Renewal');
            $message->from(config('mail.from')['address'], config('mail.from')['name']);
            $message->to(config('mail.accounts')['address'], config('mail.accounts')['name']);
        });
    }
}
