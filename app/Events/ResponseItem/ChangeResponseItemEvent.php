<?php

namespace App\Events\ResponseItem;


use App\Demand\ResponseItem;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChangeResponseItemEvent
{
    use InteractsWithSockets, SerializesModels;

    public $item;

    public $oldPrice;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ResponseItem $item, $oldPrice)
    {
        $this->item = $item;
        $this->oldPrice = $oldPrice;
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
