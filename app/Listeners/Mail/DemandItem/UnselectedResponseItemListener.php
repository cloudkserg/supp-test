<?php

namespace App\Listeners\Mail\DemandItem;

use App\Events\DemandItem\UnselectedResponseItemEvent;
use App\Mail\DemandItem\UnselectedResponseItemMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UnselectedResponseItemListener implements ShouldQueue
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
     * @param  UnselectedResponseItemEvent  $event
     * @return void
     */
    public function handle(UnselectedResponseItemEvent $event)
    {
        $demandItem = $event->item;
        $responseItem = $event->oldResponseItem;
        $admin = $responseItem->response->company->getAdmin();
        Mail::to($admin->email)->send(new UnselectedResponseItemMail($demandItem));
    }
}
