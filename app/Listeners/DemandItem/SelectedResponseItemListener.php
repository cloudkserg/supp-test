<?php

namespace App\Listeners\DemandItem;

use App\Events\DemandItem\SelectedResponseItemEvent;
use App\Mail\DemandItem\SelectedResponseItemMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SelectedResponseItemListener
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
     * @param  SelectedResponseItemEvent  $event
     * @return void
     */
    public function handle(SelectedResponseItemEvent $event)
    {
        $demandItem = $event->item;
        $responseItem = $demandItem->selectedResponseItem;
        $admin = $responseItem->response->company->getAdmin();
        \Mail::to($admin->email)->send(new SelectedResponseItemMail($demandItem));

    }
}
