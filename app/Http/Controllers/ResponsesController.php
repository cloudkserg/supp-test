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

    public function update(UpdateResponseRequest $request)
    {
        $unChangeResponse = $request->getResponse();
        $response = $this->responseService->changeItem($unChangeResponse, $request);

        $this->responseItemService->deleteAllForResponse($response);
        $this->responseItemService->createItemsForResponse($response, $request);
        return $this->response->accepted();

    }

}
