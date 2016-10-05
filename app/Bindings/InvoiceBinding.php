<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 05.10.16
 * Time: 1:01
 */

namespace App\Bindings;


use App\Demand\Invoice;
use App\Events\Invoice\CreateInvoiceEvent;
use App\Events\Invoice\DeleteInvoiceEvent;
use App\Events\Invoice\ResponsedInvoiceEvent;
use App\Listeners\Invoice\CreateInvoiceListener;
use App\Listeners\Invoice\DeleteInvoiceListener;
use App\Listeners\Invoice\ResponsedInvoiceListener;
use App\Services\InvoiceService;

class InvoiceBinding implements BindingInterface
{
    public function generateEventBindings()
    {
        $service = (new InvoiceService());
        Invoice::deleted(function (Invoice $item) use ($service) {
            $service->onDelete($item);
        });

        Invoice::updated(function (Invoice $item) use ($service) {
            $service->onUpdate($item);
        });
    }

    public function generateListenerBindings()
    {
        \Event::listen(CreateInvoiceEvent::class, CreateInvoiceListener::class);
        \Event::listen(DeleteInvoiceEvent::class, DeleteInvoiceListener::class);
        \Event::listen(ResponsedInvoiceEvent::class, ResponsedInvoiceListener::class);
    }


}