<?php

namespace App\Providers\Notifications;
use App\User;
use App\Models\Notification;

interface NotificationServiceInterface
{
    public function addNotification( $account_id, $subject, $message );
}
