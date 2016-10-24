<?php

namespace App\Http\Controllers;


use App\Services\RegionService;
use App\Transformers\RegionTransformer;
use Dingo\Api\Routing\Helpers;




class RegionsController extends Controller
{

    use Helpers;

    /**
     * @var RegionService
     */
    private $regionService;


    /**
     * @param RegionService $regionService
     */
    function __construct(RegionService $regionService)
    {
        $this->regionService = $regionService;
    }

    /**
     * @SWG\Get(
     *     path="/regions",
     *     summary="Get Regions",
     *     tags={"region"},
     *     description="",
     *     operationId="listRegions",
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/RegionModel")
     *         ),
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
     *     security={{ "token": {} }}
     * )
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->collection($this->regionService->getItems(), RegionTransformer::class);
    }



}
