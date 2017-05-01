<?php

namespace App\Listeners;

use App\Events\UserWasRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestRegistrationConfirmation
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
        \Mail::queue(['html'=>'emails.account.new'],
        ['action'=> $registration['confirmation_link']],
        function( $message ) use ($registration) {
            $message->subject('Account Confirmation');
            $message->from(config('mail.from')['address'], config('mail.from')['name']);
            $message->to($registration['manager']->email,
                        $registration['manager']->first_name . ' ' .
                        $registration['manager']->last_name);
        });
    }
}
