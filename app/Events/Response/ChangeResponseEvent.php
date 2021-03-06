<?php

namespace App\Events\Response;


use App\Demand\Response;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChangeResponseEvent
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var Response
     */
    public $item;

    /**
     * @var string
     */
    public $oldDeliveryType;

    /**
     * Create a new event instance.
     *
     * @param Response $item
     * @param string $oldDeliveryType
     */
    public function __construct(Response $item, $oldDeliveryType)
    {
        $this->item = $item;
        $this->oldDeliveryType = $oldDeliveryType;
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
