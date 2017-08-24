<?php

namespace App\Http\Controllers;

use App\Services\ResponseItemService;
use App\Services\ResponseService;
use App\Transformers\ResponseTransformer;
use Dingo\Api\Routing\Helpers;

use App\User;
use App\Company;
use App\Http\Requests;
use App\Http\Requests\UpdateResponseRequest;
use App\Http\Requests\IndexResponsesRequest;
use Swagger\Annotations as SWG;

class ResponsesController extends Controller
{

    use Helpers;

    /**
     * @var ResponseService
     */
    private $responseService;

    /**
     * @var ResponseItemService
     */
    private $responseItemService;


    /**
     *
     */
    function __construct()
    {
        $this->responseService = new ResponseService();
        $this->responseItemService = new ResponseItemService();
    }

    /**
     * @return User
     */
    private function getUser()
    {
        return $this->auth->user();
    }

    /**
     * @return Company
     */
    private function getCompany()
    {
        return $this->getUser()->company;
    }

    /**
     * @SWG\Get(
     *     path="/responses",
     *     summary="Get my responses by status",
     *     tags={"response"},
     *     description="",
     *     operationId="getResponses",
     *      @SWG\Parameter(
     *         name="status",
     *         in="query",
     *         type="string",
     *         enum={"active","archived", "draft", "cancel"},
     *         description="filtered Status [or array of status]"
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/ResponseModelWithDemand")
     *          )
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
    public function index(IndexResponsesRequest $request)
    {
         $items = $this->responseService->getItemsByCompanyAndStatus(
            $this->getCompany(), $request->status
        );
        return $this->response->collection(
            $items,
            (new ResponseTransformer())->addDemand()
        );
    }


    /**
     * @SWG\Patch(
     *     path="/responses/{id}/readed",
     *     summary="Update readed response",
     *     tags={"response"},
     *     description="",
     *     operationId="updateResponses",
     *     @SWG\Parameter(name="id", in="path", required=true, type="integer"),
     *     @SWG\Parameter(
     *          name="Response",
     *          in="body",
     *          @SWG\Schema(ref="#/definitions/UpdateReadedResponseRequest")
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
    public function updateReaded(Requests\UpdateReadedResponseRequest $request)
    {
        $unChangeResponse = $request->getResponse();
        $response = $this->responseService->setReadedItem($unChangeResponse, $request->getReaded());
        return $this->response->accepted();

    }

    /**
     * @SWG\Patch(
     *     path="/responses/{id}",
     *     summary="Update response",
     *     tags={"response"},
     *     description="",
     *     operationId="updateResponses",
     *     @SWG\Parameter(name="id", in="path", required=true, type="integer"),
     *     @SWG\Parameter(
     *          name="Response",
     *          in="body",
     *          @SWG\Schema(ref="#/definitions/UpdateResponseRequest")
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
    public function update(UpdateResponseRequest $request)
    {
        $unChangeResponse = $request->getResponse();
        $response = $this->responseService->changeItem($unChangeResponse, $request);

        $this->responseItemService->createItemsForResponse($response, $request);
        return $this->response->accepted();

    }

}
