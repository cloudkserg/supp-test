<?php

namespace App\Mail\Demand;

use App\Demand\Demand;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ArchiveDemandMail extends Mailable
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
        return $this->view('emails.demand.archive');
    }
}
