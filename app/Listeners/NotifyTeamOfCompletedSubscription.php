<?php

namespace App\Listeners;

use App\Events\PackageSubscriptionHasFinished;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Providers\ProvisionTracker\Api\UserServiceInterface;

class NotifyTeamOfCompletedSubscription
{
    /**
     * Create the event listener.
     *
     * @return void
     */
     public function __construct( UserServiceInterface $userService ) {
         $this->userService = $userService;
     }

    /**
     * Handle the event.
     *
     * @param  PackageSubscriptionHasFinished  $event
     * @return void
     */
    public function handle(PackageSubscriptionHasFinished $event)
    {
        $user = $this->userService->getUser( null, $event->account->manager_id );
        \Mail::queue(['html'=>'emails.team.subscription-complete'],
        ['account'=>$event->account, 'user'=> $user],
        function( $message ){
            $message->subject('Subscription has ended');
            $message->from(config('mail.from')['address'], config('mail.from')['name']);
            $message->to(config('mail.registrations')['address'], config('mail.registrations')['name']);
        });
    }
}
