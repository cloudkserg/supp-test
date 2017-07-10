<?php

namespace App\Listeners\Response;

use App\Events\Response\ChangeResponseEvent;
use App\Mail\Response\ChangeResponseMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChangeResponseListener
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
     * @param  ChangeResponseEvent  $event
     * @return void
     */
    public function handle(ChangeResponseEvent $event)
    {
        $item = $event->item;
        $admin = $item->demand->company->getAdmin();
        \Mail::to($admin)
            ->send(new ChangeResponseMail($item));
    }
}