<?php

namespace App\Mail\DemandItem;

use App\Demand\DemandItem;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SelectedResponseItemMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var DemandItem
     */
    public $item;

    /**
     * Create a new message instance.
     *
     * @param DemandItem $item
     */
    public function __construct(DemandItem $item)
    {
        $this->item = $item;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.demandItem.selected');
    }
}
