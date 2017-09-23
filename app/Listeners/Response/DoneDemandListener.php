<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 12.09.17
 * Time: 20:10
 */

namespace App\Listeners\Response;


use App\Demand\Response;
use App\Events\Demand\CancelDemandEvent;
use App\Services\ResponseService;
use App\Type\ResponseStatus;
use Illuminate\Contracts\Queue\ShouldQueue;

class DoneDemandListener implements ShouldQueue
{

    /**
     * @var ResponseService
     */
    private $responseService;

    /**
     * Create the event listener.
     **/
    public function __construct(ResponseService $responseService)
    {
        //
        $this->responseService = $responseService;
    }

    /**
     * Handle the event.
     *
     * @param  CancelDemandEvent  $event
     * @return void
     */
    public function handle(CancelDemandEvent $event)
    {
        $item = $event->item;
        foreach ($item->responses as $response) {
            if ($response->status == ResponseStatus::ACTIVE) {
                $this->cancelItem($response);
            }
        }
    }


    private function cancelItem(Response $response)
    {
        $this->responseService->cancelItem($response);
    }

}