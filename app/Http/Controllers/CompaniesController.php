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
     * Display a listing of the resource.
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
