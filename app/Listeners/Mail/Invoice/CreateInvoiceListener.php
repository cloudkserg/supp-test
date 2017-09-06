<?php

namespace App\Listeners\Mail\Invoice;

use App\Events\Invoice\CreateInvoiceEvent;
use App\Mail\Invoice\CreateInvoiceMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateInvoiceListener
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
     * @param  CreateInvoiceEvent  $event
     * @return void
     */
    public function handle(CreateInvoiceEvent $event)
    {
        $item = $event->item;
        $admin = $item->response->company->getAdmin();
        \Mail::to($admin->email)
            ->send(new CreateInvoiceMail($item));
    }
}
