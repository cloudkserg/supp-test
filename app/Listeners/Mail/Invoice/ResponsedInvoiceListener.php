<?php

namespace App\Listeners\Mail\Invoice;

use App\Events\Invoice\ResponsedInvoiceEvent;
use App\Mail\Invoice\ResponsedInvoiceMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResponsedInvoiceListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ResponsedInvoiceEvent  $event
     * @return void
     */
    public function handle(ResponsedInvoiceEvent $event)
    {
        $item = $event->item;
        $admin = $item->response->demand->company->getAdmin();
        \Mail::to($admin->email)
            ->send(new ResponsedInvoiceMail($item));
    }
}
