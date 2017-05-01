<?php

namespace App\Listeners;

use App\Events\TrialPeriodhasFinished;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Providers\ProvisionTracker\Api\UserServiceInterface;
use App\Providers\Notifications\NotificationServiceInterface;
use App\Providers\ProvisionTracker\Api\AccountServiceInterface;
use App\Providers\ProvisionTracker\UniqueIdServiceInterface;

class NotifyUserOfCompletedTrial
{
    /**
     * Create the event listener.
     *
     * @return void
     */
     public function __construct( UserServiceInterface $userService,
                                  NotificationServiceInterface $notificationService,
                                  AccountServiceInterface $accountService,
                                  UniqueIdServiceInterface $idService) {
        $this->userService = $userService;
        $this->notificationService = $notificationService;
        $this->accountService = $accountService;
        $this->idService = $idService;
     }

    /**
     * Handle the event.
     *
     * @param  TrialPeriodhasFinished  $event
     * @return void
     */
    public function handle(TrialPeriodhasFinished $event) {
        //-------------------------
        // Create an action for the user to respond to
        $event_class = 'App\Events\AccountRenewalWasRequested';
        $action_code = $this->idService->ptId();
        $action_link = \Request::root() . "/app/settings/notifications/action/$action_code";
        $this->accountService->addAccountAction($event->account->id, 'renew', 'pending', $action_code, $event_class);

        //-------------------------
        // Mail the user first
        $user = $this->userService->getUser( null, $event->account->manager_id );
        \Mail::queue(['html'=>'emails.account.trial-complete'],
        ['account'=>$event->account, 'user'=> $user, 'action'=>$action_link],
        function( $message ) use ($user) {
            $message->subject('Your Trial Period has ended');
            $message->from(config('mail.from')['address'], config('mail.from')['name']);
            $message->to($user->email, "$user->first_name $user->last_name");
        });

        //-------------------------
        // Then add a notification to their account
        $subject = "Your trial has ended";
        $message = "Update your package to continue";
        $this->notificationService->addNotification( $event->account->id, $subject, $message);
    }
}
