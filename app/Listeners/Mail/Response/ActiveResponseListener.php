<?php

namespace App\Listeners\Mail\Response;

use App\Events\Response\ActiveResponseEvent;
use App\Mail\Response\ActiveResponseMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ActiveResponseListener implements ShouldQueue
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
     * @param  ActiveResponseEvent  $event
     * @return void
     */
    public function handle(ActiveResponseEvent $event)
    {
        $item = $event->item;
        $admin = $item->demand->company->getAdmin();
        \Mail::to($admin)
            ->send(new ActiveResponseMail($item));
    }
}
