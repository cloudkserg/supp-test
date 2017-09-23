<?php

namespace App\Listeners\Mail\Invoice;

use App\Events\Invoice\DeleteInvoiceEvent;
use App\Mail\Invoice\DeleteInvoiceMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeleteInvoiceListener implements ShouldQueue
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
     * @param  DeleteInvoiceEvent  $event
     * @return void
     */
    public function handle(DeleteInvoiceEvent $event)
    {
        $item = $event->item;
        $admin = $item->response->demand->company->getAdmin();
        \Mail::to($admin->email)
            ->send(new DeleteInvoiceMail($item));
    }
}
