<?php

namespace App\Http\Controllers;


use App\Services\ResponseItemService;
use Dingo\Api\Routing\Helpers;

use App\Http\Requests;
use App\Http\Requests\UpdateResponseItemRequest;
use Swagger\Annotations as SWG;

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



    /**
     * @SWG\Patch(
     *     path="/responseItems/{id}",
     *     summary="Update ResponseItem",
     *     tags={"responseItem"},
     *     description="",
     *     operationId="updateResponseItem",
     *     @SWG\Parameter(name="id", in="path", type="integer"),
     *     @SWG\Parameter(
     *          name="ResponseItem",
     *          in="body",
     *          @SWG\Schema(ref="#/definitions/UpdateResponseItemRequest")
     *      ),
     *     @SWG\Response(
     *         response=202,
     *         description="successful operation",
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
    public function update(UpdateResponseItemRequest $request)
    {
        //update
        $this->responseItemService->changeItem($request->getResponseItem(), $request->all());
        return $this->response->accepted();

    }

    /**
     * @SWG\Delete(
     *     path="/responseItems/{id}",
     *     summary="Delete responseItem",
     *     tags={"responseItem"},
     *     description="",
     *     operationId="deleteResponseItem",
     *     @SWG\Parameter(
     *          name="id",
     *          in="query",
     *          required=true,
     *          type="integer"
     *      ),
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
    public function delete(Requests\DeleteResponseItemRequest $request)
    {
        $this->responseItemService->deleteItem($request->getResponseItem());
        return $this->response->accepted();
    }
}
