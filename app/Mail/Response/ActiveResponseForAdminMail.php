<?php

namespace App\Mail\Response;

use App\Demand\Response;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ActiveResponseForAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Response
     */
    public $item;

    /**
     * Create a new message instance.
     *
     * @param Response $item
     */
    public function __construct(Response $item)
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
        return $this->view('emails.response.active_admin');
    }
}
