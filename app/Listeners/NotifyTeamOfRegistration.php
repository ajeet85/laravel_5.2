<?php

namespace App\Listeners;

use App\Events\UserWasRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyTeamOfRegistration
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserWasRegistered  $event
     * @return void
     */
    public function handle(UserWasRegistered $event)
    {
        $registration = $event->registration;
        \Mail::queue(['html'=>'emails.team.new-registration'],
        ['user'=>$event->registration['manager']],
        function( $message ) use ( $registration ) {
            $message->subject('New Provision Tracker Registration');
            $message->from(config('mail.from')['address'], config('mail.from')['name']);
            $message->to(config('mail.registrations')['address'], config('mail.registrations')['name']);
        });
    }
}
