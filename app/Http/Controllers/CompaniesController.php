<?php

namespace App\Http\Controllers;


use App\Http\Requests\SearchCompanyRequest;
use App\Services\CompanyService;
use Dingo\Api\Routing\Helpers;




class CompaniesController extends Controller
{

    use Helpers;

    /**
     * @var CompanyService
     */
    private $companyService;

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
     *
     */
    function __construct()
    {
        $this->companyService = new CompanyService();
    }

    /**
     * @SWG\Get(
     *     path="/companies/search",
     *     summary="Finds Companies by spheres and regions",
     *     tags={"company"},
     *     description="",
     *     operationId="findCompanyBySphereAndRegion",
     *      @SWG\Parameter(
     *         name="regions",
     *         in="query",
     *         description="Region to filter by",
     *         required=true,
     *         type="array",
     *         @SWG\Items(type="integer"),
     *      ),
     *     @SWG\Parameter(
     *         name="spheres",
     *         in="query",
     *         description="Sphere to filter by",
     *         required=true,
     *         type="array",
     *         @SWG\Items(type="integer"),
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="count", type="integer")
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
     *
     * @param SearchCompanyRequest $request
     * @return \Illuminate\Http\Response
     */
    public function search(SearchCompanyRequest $request)
    {
        $count = $this->companyService->countAvailableCompanies(
            $this->getCompany(), $request->spheres, $request->regions
        );
        return compact('count');
    }



}
