<?php

namespace App\Mail\Invoice;

use App\Demand\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResponsedInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Invoice
     */
    public $item;

    /**
     * Create a new message instance.
     *
     * @param Invoice $item
     */
    public function __construct(Invoice $item)
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
        return $this->view('emails.invoice.responsed')
        ->subject('Компания ' . $this->item->response->company->title . ' загрузила счет');
    }
}
