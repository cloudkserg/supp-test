<?php

namespace App\Http\Controllers;

use App\Events\Demand\CreateDemandEvent;
use App\Jobs\CreateDraftResponseForDemandJob;
use App\Services\DemandItemService;
use App\Services\DemandService;
use Dingo\Api\Routing\Helpers;

use App\User;
use App\Company;
use App\Http\Requests;
use App\Transformers\DemandTransformer;
use App\Http\Requests\CreateDemandRequest;
use App\Http\Requests\IndexDemandsRequest;
use App\Http\Requests\UpdateDemandRequest;
use Swagger\Annotations as SWG;

class DemandsController extends Controller
{

    use Helpers;

    /**
     * @var DemandService
     */
    private $demandService;

    /**
     * @var DemandItemService
     */
    private $demandItemService;


    /**
     *
     */
    function __construct()
    {
        $this->demandService = new DemandService();
        $this->demandItemService = new DemandItemService();
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
     *     path="/demands",
     *     summary="Get my demands by status",
     *     tags={"demand"},
     *     description="",
     *     operationId="getDemands",
     *      @SWG\Parameter(
     *         name="status",
     *         in="query",
     *         type="string",
     *         enum={"active","archived"},
     *         description="filtered Status [or array of status]"
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/DemandModelWithResponses")
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
    /**
     * Display a listing of the resource.
     *
     * @param IndexDemandsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(IndexDemandsRequest $request)
    {
        $items = $this->demandService->getItemsByCompanyAndStatus(
            $this->getCompany(), $request->status
        );
        return $this->response->collection(
            $items,
            (new DemandTransformer())->addActiveResponses()
        );

    }

    /**
     * @SWG\Post(
     *     path="/demands/done",
     *     summary="Done demand",
     *     tags={"demand"},
     *     description="",
     *     operationId="doneDemands",
     *     @SWG\Parameter(
     *          name="Demand",
     *          in="body",
     *          @SWG\Schema(ref="#/definitions/StatusDemandRequest")
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
    public function storeDone(Requests\Demand\DoneDemandRequest $request)
    {
        $demand = $request->getDemand();
        $this->demandService->doneItem($demand);

        return $this->response->accepted();
    }

    /**
     * @SWG\Post(
     *     path="/demands/cancel",
     *     summary="Cancel demand",
     *     tags={"demand"},
     *     description="",
     *     operationId="cancelDemands",
     *     @SWG\Parameter(
     *          name="Demand",
     *          in="body",
     *          @SWG\Schema(ref="#/definitions/StatusDemandRequest")
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
    public function storeCancel(Requests\Demand\CancelDemandRequest $cancelRequest)
    {
        $demand = $cancelRequest->getDemand();
        $this->demandService->cancelItem($demand);

        return $this->response->accepted();
    }

    /**
     * @SWG\Post(
     *     path="/demands/active",
     *     summary="Active demand",
     *     tags={"demand"},
     *     description="",
     *     operationId="activeDemands",
     *     @SWG\Parameter(
     *          name="Demand",
     *          in="body",
     *          @SWG\Schema(ref="#/definitions/StatusDemandRequest")
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
    public function storeActive(Requests\Demand\ActiveDemandRequest $activeRequest)
    {
        $demand = $activeRequest->getDemand();
        $this->demandService->activeItem($demand);

        event(new ActiveDemandEvent($demand));
        dispatch(new CreateDraftResponseForDemandJob($demand));
        return $this->response->accepted();
    }

    /**
     * @SWG\Post(
     *     path="/demands",
     *     summary="Create demand",
     *     tags={"demand"},
     *     description="",
     *     operationId="createDemands",
     *     @SWG\Parameter(
     *          name="Demand",
     *          in="body",
     *          @SWG\Schema(ref="#/definitions/CreateDemandRequest")
     *      ),
     *     @SWG\Response(
     *         response=201,
     *         description="successful operation",
     *         @SWG\Header(header="location", type="string", description="/demands/1")
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
    public function store(CreateDemandRequest $createRequest)
    {
        $demand = $this->demandService->addItem($this->getCompany()->id, $createRequest);
        $this->demandItemService->addItems($demand, $createRequest);

        event(new CreateDemandEvent($demand));
        dispatch(new CreateDraftResponseForDemandJob($demand));
        return $this->response->created('/demands/' . $demand->id);
    }

    /**
     * @SWG\Patch(
     *     path="/demands/{id}",
     *     summary="Update demand",
     *     tags={"demand"},
     *     description="",
     *     operationId="updateDemands",
     *     @SWG\Parameter(name="id", in="path", required=true, type="integer"),
     *     @SWG\Parameter(
     *          name="Demand",
     *          in="body",
     *          @SWG\Schema(ref="#/definitions/UpdateDemandRequest")
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
    public function update(UpdateDemandRequest $request)
    {
        //updateStatus
        $this->demandService->changeItem($request->getDemand(), $request);
        return $this->response->accepted();

    }

    /**
     * @SWG\Delete(
     *     path="/demands/{id}",
     *     summary="Delete demand",
     *     tags={"demand"},
     *     description="",
     *     operationId="deleteDemands",
     *     @SWG\Parameter(name="id", in="path", required=true, type="integer"),
     *     @SWG\Response(
     *         response=201,
     *         description="successful operation",
     *         @SWG\Header(header="location", type="string", description="/demands/1")
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
    public function delete(Requests\DeleteDemandRequest $request)
    {
        $this->demandService->delete($request->getDemand());
        return $this->response->accepted();
    }
}
