<?php

namespace moum\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OldUserLogin
{
    use InteractsWithSockets, SerializesModels;

    public $profile_image_url;

    public $userId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($profile_image_url, $userId)
    {
        $this->profile_image_url = $profile_image_url;
        $this->userId = $userId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
