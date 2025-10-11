<?php

namespace App\Events;

use App\Models\Chirp;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChirpSent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chirp;

    /**
     * Create a new event instance.
     */
    public function __construct($chirp)
    {
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
