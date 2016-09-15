<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 17:27
 */

namespace App\Services;
use App\Company;
use App\Http\Requests\User\CreateUserRequest;
use App\Repository\CompanyRepository;

class CompanyService
{

    private $repo;

    function __construct()
    {
        $this->repo = new CompanyRepository();
    }


    /**
     * @param CreateUserRequest $request
     * @return Company
     */
    public function createCompany(CreateUserRequest $request)
    {
        $company = new Company();
        $company->title = $request->company_title;
        $company->save();
        return $company;
    }

    public function countSearchItems(array $spheres, array $regions)
    {
        return $this->repo->countBySpheresAndRegions($spheres, $regions);
    }

}