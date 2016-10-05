<?php

namespace App\Mail\ResponseItem;

use App\Demand\ResponseItem;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeleteResponseItemMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var ResponseItem
     */
    public $item;

    /**
     * Create a new message instance.
     *
     * @param ResponseItem $item
     */
    public function __construct(ResponseItem $item)
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
        return $this->view('emails.responseItem.delete');
    }
}
