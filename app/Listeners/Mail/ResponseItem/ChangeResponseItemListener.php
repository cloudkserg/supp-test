<?php

namespace App\Listeners\Mail\ResponseItem;

use App\Events\ResponseItem\ChangeResponseItemEvent;
use App\Mail\ResponseItem\ChangeResponseItemMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChangeResponseItemListener
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
     * @param  ChangeResponseItemEvent  $event
     * @return void
     */
    public function handle(ChangeResponseItemEvent $event)
    {
        $item = $event->item;
        $admin = $item->response->demand->company->getAdmin();
        \Mail::to($admin)
            ->send(new ChangeResponseItemMail($item));
    }
}
