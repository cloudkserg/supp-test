<?php

namespace App\Events\DemandItem;

use App\Demand\DemandItem;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SelectedResponseItemEvent
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var DemandItem
     */
    public $item;

    /**
     * Create a new event instance.
     *
     * @param DemandItem $item
     */
    public function __construct(DemandItem $item)
    {
        $this->item = $item;
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
