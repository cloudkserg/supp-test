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



    /**
     * @SWG\Patch(
     *     path="/demandItems/{id}",
     *     summary="Update demandItem",
     *     tags={"demandItem"},
     *     description="",
     *     operationId="updateDemandItem",
     *      @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="DemandItem id",
     *         required=true,
     *         type="integer",
     *      ),
     *     @SWG\Parameter(
     *         name="DemandItem",
     *         in="body",
     *         @SWG\Schema(ref="#/definitions/UpdateDemandItemRequest")
     *     ),
     *     @SWG\Response(
     *         response=202,
     *         description="successful operation"
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         ref="#/responses/NotFoundResponse"
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         ref="#/responses/NotAuthResponse"
     *     ),
     *     @SWG\Response(
     *         response="default",
     *         ref="#/responses/DefaultErrorResponse"
     *     ),
     *
     *     security={{ "token": {} }}
     * )
     */
    public function update(UpdateDemandItemRequest $request)
    {
        //updateResponseItem
        if (isset($request->responseItemId)) {
            $this->demandItemService->selectResponseItem($request->getDemandItem(), $request->responseItemId);
        } else {
            $this->demandItemService->unselectResponseItem($request->getDemandItem());
        }
        return $this->response->accepted();

    }
}
