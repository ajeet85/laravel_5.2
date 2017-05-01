<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AccountRenewalWasRequested extends Event
{
    use SerializesModels;
    public $action_code;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct( $action_code )
    {
        $this->action_code = $action_code;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
