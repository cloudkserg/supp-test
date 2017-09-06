<?php

namespace App\Listeners\Mail\Response;

use App\Events\Response\CancelResponseEvent;
use App\Mail\Response\CancelResponseMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CancelResponseListener
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
     * @param  CancelResponseEvent  $event
     * @return void
     */
    public function handle(CancelResponseEvent $event)
    {
        $item = $event->item;
        $admin = $item->demand->company->getAdmin();
        \Mail::to($admin)
            ->send(new CancelResponseMail($item));
    }
}
