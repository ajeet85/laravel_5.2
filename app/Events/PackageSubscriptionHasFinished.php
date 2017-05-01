<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PackageSubscriptionHasFinished extends Event
{
    use SerializesModels;
    public $account;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct( $account )
    {
        $this->account = $account;
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
