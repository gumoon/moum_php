<?php

namespace moum\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use moum\Models\Shop;

class AccessShopEvent
{
    use InteractsWithSockets, SerializesModels;

    public $shop;

    public $arr;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Shop $shop, $arr = [])
    {
        $this->shop = $shop;
        $this->arr = $arr;
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
