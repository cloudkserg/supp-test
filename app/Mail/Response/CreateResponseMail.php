<?php

namespace App\Mail\Response;

use App\Demand\Demand;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateResponseMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Demand
     */
    public $item;

    /**
     * Create a new message instance.
     *
     * @param Demand $item
     */
    public function __construct(Demand $item)
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
        return $this->view('emails.response.create')
            ->subject('Новая заявка от ' . $this->item->company->title);
    }
}
