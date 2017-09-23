<?php

namespace App\Listeners\Mail\Response;

use App\Events\Response\CreateResponseEvent;
use App\Mail\Response\CreateResponseMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateResponseListener implements ShouldQueue
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
     * @param  CreateResponseEvent  $event
     * @return void
     */
    public function handle(CreateResponseEvent $event)
    {
        $item = $event->item;
        $admin = $item->company->getAdmin();
        \Mail::to($admin)
            ->send(new CreateResponseMail($item->demand));
    }
}
