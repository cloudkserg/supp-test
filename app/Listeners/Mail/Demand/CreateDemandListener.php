<?php

namespace App\Listeners\Mail\Demand;

use App\Demand\Demand;
use App\Demand\Response;
use App\Events\Demand\CreateDemandEvent;
use App\Mail\AdminMailer;
use App\Mail\Demand\CreateDemandForAdminMail;
use App\Type\ResponseStatus;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateDemandListener implements ShouldQueue
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
     * @param  CreateDemandEvent  $event
     * @return void
     */
    public function handle(CreateDemandEvent $event)
    {
        (new AdminMailer())->sendMails(new CreateDemandForAdminMail($event->item));
    }

}
