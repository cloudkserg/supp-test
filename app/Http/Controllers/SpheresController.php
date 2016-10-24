<?php

namespace App\Http\Controllers;


use App\Services\SphereService;
use App\Transformers\SphereTransformer;
use Dingo\Api\Routing\Helpers;




class SpheresController extends Controller
{

    use Helpers;

    /**
     * @var SphereService
     */
    private $sphereService;


    /**
     * @param SphereService $sphereService
     */
    function __construct(SphereService $sphereService)
    {
        $this->sphereService = $sphereService;
    }

    /**
     * @SWG\Get(
     *     path="/spheres",
     *     summary="Get Spheres",
     *     tags={"sphere"},
     *     description="",
     *     operationId="listSpheres",
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/SphereModel")
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
        return $this->collection($this->sphereService->getItems(), SphereTransformer::class);
    }



}
