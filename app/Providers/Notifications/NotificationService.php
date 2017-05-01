<?php

namespace App\Providers\Notifications;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Notification;
use App\Providers\Notifications\NotificationServiceInterface;

class NotificationService implements NotificationServiceInterface
{
    public function __construct(  )
    {

    }

    /**
     * [sendNotification description]
     * @param  [type] $account [description]
     * @return [type]          [description]
     */
    public function addNotification( $account_id, $subject, $message ) {
        $notification = new Notification();
        $notification->account_id = $account_id;
        $notification->subject = $subject;
        $notification->message = $message;
        $notification->save();
    }

}
