<?php

namespace App\Http\Controllers;

use App\Company;
use App\Jobs\CreateDraftResponseForCompanyJob;
use App\Services\CompanyService;
use App\Http\Requests\User\CreateUserRequest;

use App\Transformers\CompanyTransformer;
use Dingo\Api\Routing\Helpers;
use Swagger\Annotations as SWG;
/**
 */
class CompaniesController extends Controller
{

    use Helpers;
    /**
     * @var CompanyService
     */
    private $companyService;


    /**
     *
     */
    public function __construct()
    {
        $this->companyService = new CompanyService();
    }


    /**
     * @SWG\Get(
     *     path="/companies/{id}",
     *     summary="Company get",
     *     tags={"company"},
     *     description="",
     *     operationId="company",
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Company id",
     *         required=true,
     *         type="integer",
     *      ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref="#/definitions/CompanyModel")
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
     *
     * )
     */
    public function get(Company $company)
    {
        return $this->collection($company,  (new CompanyTransformer())->addRegions()->addSpheres());
    }

}
