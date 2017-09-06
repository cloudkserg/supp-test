<?php

namespace App\Listeners\Mail\Demand;

use App\Demand\Demand;
use App\Demand\Response;
use App\Events\Demand\ArchiveDemandEvent;
use App\Events\Demand\DeleteDemandEvent;
use App\Mail\Demand\ArchiveDemandMail;
use App\Mail\Demand\DeleteDemandMail;
use App\Type\ResponseStatus;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeleteDemandListener
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
     * @param  DeleteDemandEvent  $event
     * @return void
     */
    public function handle(DeleteDemandEvent $event)
    {
        $item = $event->item;
        foreach ($item->responses as $response) {
            if ($response->status == ResponseStatus::ACTIVE) {
                $this->sendMail($response, $item);
            }
        }
    }

    /**
     * @param Response $response
     * @param Demand $item
     */
    private function sendMail(Response $response, Demand $item)
    {
        $user = $response->company->getAdmin();
        \Mail::to($user->email)
            ->send(new DeleteDemandMail($item));
    }
}
