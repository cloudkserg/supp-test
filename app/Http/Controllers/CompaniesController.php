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
    private $_companyService;




    /**
     *
     */
    function __construct()
    {
        $this->_companyService = new CompanyService();
    }

    /**
     * Display a listing of the resource.
     *
     * @param SearchCompanyRequest $request
     * @return \Illuminate\Http\Response
     */
    public function search(SearchCompanyRequest $request)
    {
        $count = $this->_companyService->countSearchItems($request->spheres, $request->regions);
        return compact('count');
    }



}
