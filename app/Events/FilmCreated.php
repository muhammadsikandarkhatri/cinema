<?php

namespace App\Events;

use App\Film;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FilmCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $film;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Film $film)
    {
        $this->film = $film;
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
