<?php

namespace App\Events\Demand;

use App\Demand\Demand;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DeleteDemandEvent
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var Demand
     */
    public $item;

    /**
     * Create a new event instance.
     *
     * @param Demand $item
     */
    public function __construct(Demand $item)
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
