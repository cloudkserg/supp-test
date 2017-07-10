<?php

namespace App\Http\Controllers;


use App\Services\QuantityService;
use App\Transformers\QuantityTransformer;
use Dingo\Api\Routing\Helpers;




class QuantitiesController extends Controller
{

    use Helpers;

    /**
     * @var QuantityService
     */
    private $quantityService;


    /**
     * @param QuantityService $quantityService
     */
    function __construct(QuantityService $quantityService)
    {
        $this->quantityService = $quantityService;
    }

    /**
     * @SWG\Get(
     *     path="/quantities",
     *     summary="Get Quantities",
     *     tags={"quantity"},
     *     description="",
     *     operationId="listQuantities",
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/QuantityModel")
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
        return $this->collection($this->quantityService->getItems(), QuantityTransformer::class);
    }



}
