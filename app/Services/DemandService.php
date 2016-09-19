<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 16:39
 */

namespace App\Services;


use App\Demand\Response;
use Illuminate\Database\Eloquent\Collection;
use App\Queries\DemandQuery;
use App\Company;
use App\Http\Requests\CreateDemandRequest;
use App\Queries\DemandRelationLoader;
use App\Repository\DemandRepository;
use App\Type\DemandStatus;
use App\Demand\Demand;

class DemandService
{

    /**
     * @var DemandRepository
     */
    private $repo;

    /**
     *
     */
    function __construct()
    {
        $this->repo = new DemandRepository();
    }


    /**
     * @param Company $company
     * @param string|array|null $status
     * @return Collection
     */
    public function getItemsByCompanyAndStatus(Company $company, $status)
    {
        $query = new DemandQuery();
        $query->forCompany($company->id);
        if (isset($status)) {
            $query->forStatus($status);
        }

        return $this->repo->findAll($query->getBuilder());
    }



    public function addItem($companyId, CreateDemandRequest $createRequest)
    {
        $item = new Demand();
        $item->fill($createRequest->all());
        $item->delivery_date = $createRequest->getDeliveryDate();
        $item->company_id = $companyId;
        $item->status = DemandStatus::ACTIVE;
        $item->save();
        return $item;
    }


    /**
     * @param $id
     * @return Demand
     */
    public function findItem($id)
    {
        return $this->repo->findById($id);
    }

    /**
     * @param Demand $item
     * @param $status
     */
    public function changeItemStatus(Demand $item, $status)
    {
        if ($item->status !== $status) {
            $item->status = $status;
            $item->save();
        }
    }

    /**
     * @param Company $company
     * @return Collection|static[]
     */
    public function findAvailableResponseDemands(Company $company)
    {
        $query = new DemandQuery();
        $query
            ->forNotCompany($company->id)
            ->forStatus(DemandStatus::ACTIVE)
            ->forSphere($company->spheres->pluck('id')->toArray())
            ->forRegion($company->regions->pluck('id')->toArray())
            ->forNotCompanyResponse($company->id);

        return  $this->repo->findAll($query->getBuilder());
    }


}