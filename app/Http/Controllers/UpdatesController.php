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
use Swagger\Annotations\Property;


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
     * @SWG\Get(
     *     path="/updates",
     *     summary="Get updates in demands and responses for me",
     *     tags={"update"},
     *     description="",
     *     operationId="getUpdates",
     *      @SWG\Parameter(
     *         name="timestamp",
     *         in="query",
     *         type="integer",
     *         description="Time after that need check updates"
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *              type="object",
     *              @Property(property="demands", type="boolean", description="update demands or not"),
     *              @Property(property="responses", type="boolean", description="update responses or not"),
     *              @Property(property="timestamp", type="integer", description="last timestamp of this check"),
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
    public function index(Requests\UpdatesRequest $request)
    {

        $demandStatus = $this->demandService->isChangeAfterTimestamp($this->getCompany(), $request->getTime());
        $responseStatus = $this->responseService->isChangeAfterTimestamp($this->getCompany(), $request->getTime());
        $time = time();

        return ['demands' => $demandStatus, 'responses' => $responseStatus, 'timestamp' => $time];

    }


}
