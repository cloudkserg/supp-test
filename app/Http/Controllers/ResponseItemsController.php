<?php

namespace App\Http\Controllers;


use App\Services\ResponseItemService;
use Dingo\Api\Routing\Helpers;

use App\Http\Requests;
use App\Http\Requests\UpdateResponseItemRequest;


class ResponseItemsController extends Controller
{

    use Helpers;


    /**
     * @var ResponseItemService
     */
    private $responseItemService;


    /**
     *
     */
    function __construct()
    {
        $this->responseItemService = new ResponseItemService();
    }




    public function update(UpdateResponseItemRequest $request)
    {
        //update
        $this->responseItemService->changeItem($request->getResponseItem(), $request->all());
        return $this->response->accepted();

    }

    public function delete(UpdateResponseItemRequest $request)
    {
        $this->responseItemService->deleteItem($request->getResponseItem());
        return $this->response->accepted();
    }
}
