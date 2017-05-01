<?php

namespace App\Listeners;

use App\Events\TrialPeriodhasFinished;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Providers\ProvisionTracker\Api\UserServiceInterface;

class NotifyTeamOfCompletedTrial
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
     * @param  TrialPeriodhasFinished  $event
     * @return void
     */
    public function handle(TrialPeriodhasFinished $event) {
        $user = $this->userService->getUser( null, $event->account->manager_id );
        \Mail::queue(['html'=>'emails.team.trial-complete'],
        ['account'=>$event->account, 'user'=> $user],
        function( $message ){
            $message->subject('Trial Period has ended');
            $message->from(config('mail.from')['address'], config('mail.from')['name']);
            $message->to(config('mail.registrations')['address'], config('mail.registrations')['name']);
        });
    }
}
