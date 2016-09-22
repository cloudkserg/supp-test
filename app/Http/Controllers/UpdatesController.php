<?php

namespace App\Http\Controllers;

use App\Jobs\CreateDraftResponseForDemandJob;
use App\Jobs\CreateDraftResponseJob;
use App\Services\DemandItemService;
use App\Services\DemandService;
use App\Services\ResponseService;
use Dingo\Api\Routing\Helpers;

use App\User;
use App\Company;
use App\Http\Requests;
use App\Transformers\DemandTransformer;
use App\Http\Requests\CreateDemandRequest;
use App\Http\Requests\IndexDemandsRequest;
use App\Http\Requests\UpdateDemandRequest;


class UpdatesController extends Controller
{

    use Helpers;

    /**
     * @var DemandService
     */
    private $demandService;

    /**
     * @var ResponseService
     */
    private $responseService;


    /**
     *
     */
    function __construct()
    {
        $this->demandService = new DemandService();
        $this->responseService = new ResponseService();
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
     * @param UpdatesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(Requests\UpdatesRequest $request)
    {

        $demandStatus = $this->demandService->isChangeAfterTimestamp($this->getCompany(), $request->getTime());
        $responseStatus = $this->responseService->isChangeAfterTimestamp($this->getCompany(), $request->getTime());
        $time = time();

        return ['demands' => $demandStatus, 'responses' => $responseStatus, 'timestamp' => $time];

    }


}
