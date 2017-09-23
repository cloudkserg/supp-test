<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 23.09.17
 * Time: 15:37
 */

namespace App\Events\Demand;


use App\Demand\Demand;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;

class CreateDemandEvent
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