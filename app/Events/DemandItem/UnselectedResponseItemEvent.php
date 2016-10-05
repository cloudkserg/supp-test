<?php

namespace App\Events\DemandItem;

use App\Demand\DemandItem;
use App\Demand\ResponseItem;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UnselectedResponseItemEvent
{
    use InteractsWithSockets, SerializesModels;

    public $item;
    public $oldResponseItem;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(DemandItem $item, ResponseItem $oldResponseItem)
    {
        $this->item = $item;
        $this->oldResponseItem = $oldResponseItem;
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
