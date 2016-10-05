<?php

namespace App\Events\Invoice;

use App\Demand\Invoice;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CreateInvoiceEvent
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var Invoice
     */
    public $item;

    /**
     * Create a new event instance.
     *
     * @param Invoice $item
     */
    public function __construct(Invoice $item)
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
