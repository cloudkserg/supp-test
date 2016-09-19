<?php

namespace App\Http\Controllers;

use App\Jobs\CreateDraftResponseForDemandJob;
use App\Jobs\CreateDraftResponseJob;
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
            (new DemandTransformer())->addResponses()
        );

    }

    public function store(CreateDemandRequest $createRequest)
    {
        $demand = $this->demandService->addItem($this->getCompany()->id, $createRequest);
        $this->demandItemService->addItems($demand, $createRequest);

        dispatch(new CreateDraftResponseForDemandJob($demand));
        return $this->response->created('/demands/' . $demand->id);
    }


    public function update(UpdateDemandRequest $request)
    {
        //updateStatus
        $this->demandService->changeItemStatus($request->getDemand(), $request->status);
        return $this->response->accepted();

    }
}
