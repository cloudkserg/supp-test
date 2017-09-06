<?php

namespace App\Listeners\Mail\ResponseItem;

use App\Events\ResponseItem\DeleteResponseItemEvent;
use App\Mail\ResponseItem\DeleteResponseItemMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeleteResponseItemListener
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
     * @param  DeleteResponseItemEvent  $event
     * @return void
     */
    public function handle(DeleteResponseItemEvent $event)
    {
        $item = $event->item;
        $admin = $item->response->demand->company->getAdmin();
        \Mail::to($admin)
            ->send(new DeleteResponseItemMail($item));
    }
}
