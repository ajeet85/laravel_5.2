<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserWasRegistered extends Event
{
    use SerializesModels;
    public $registration;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct( $registration ) {
        $this->registration = $registration;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn() {
        return [];
    }
}
