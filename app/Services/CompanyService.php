<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 17:27
 */

namespace App\Services;
use App\Company;
use App\Demand\Demand;
use App\Http\Requests\User\CreateUserRequest;
use App\Queries\CompanyQuery;
use App\Repository\CompanyRepository;
use App\Type\Quantity;

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
        $company->saveOrFail();

        $company->regions()->attach($request->get('regions'));
        $company->spheres()->attach($request->get('spheres'));

        return $company;
    }

    public function countAvailableCompanies(Company $company, array $spheres, array $regions)
    {
        $query = new CompanyQuery();
        $query->forNotCompany($company->id)
            ->forRegion($regions)
            ->forSphere($spheres);

        return $this->repo->count($query->getBuilder());
    }

    public function findAvailableResponseCompanies(Demand $demand)
    {
        $query = new CompanyQuery();
        $query->forNotCompany($demand->company_id)
            ->forRegion($demand->regions->pluck('id')->toArray())
            ->forSphere($demand->spheres->pluck('id')->toArray())
            ->hasNotResponses($demand->id);

        return $this->repo->findAll($query->getBuilder());
    }

}