<?php

namespace App\Http\Controllers;


use App\Services\DemandItemService;
use Dingo\Api\Routing\Helpers;

use App\Http\Requests;
use App\Http\Requests\UpdateDemandItemRequest;


class DemandItemsController extends Controller
{

    use Helpers;


    /**
     * @var DemandItemService
     */
    private $demandItemService;


    /**
     *
     */
    function __construct()
    {
        $this->demandItemService = new DemandItemService();
    }




    public function update(UpdateDemandItemRequest $request)
    {
        //updateStatus
        $this->demandItemService->selectResponseItem($request->getDemandItem(), $request->response_item_id);
        return $this->response->accepted();

    }
}
