<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChirpSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chirp;

    /**
     * Create a new event instance.
     */
    public function __construct($chirp)
    {
        // If $chirp is a model, load the user relationship
        $chirp->load('user');
        $this->chirp = $chirp;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    // Broadcast via public channel
    public function broadcastOn()
    {
        return new Channel('public-chirps');
    }

    public function broadcastAs()
    {
        return 'chirp.sent';
    }
}
