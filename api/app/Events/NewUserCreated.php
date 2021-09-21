<?php

namespace App\Events;

use App\Models\PotentialUser;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewUserCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The potential user instance.
     *
     * @var \App\Models\PotentialUser
     */
    public $potentialUser;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(PotentialUser $potentialUser)
    {
        $this->potentialUser = $potentialUser;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
