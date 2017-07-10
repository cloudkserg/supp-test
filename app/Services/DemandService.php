<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 16:39
 */

namespace App\Services;



use App\Events\Demand\ArchiveDemandEvent;
use Carbon\Carbon;
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
        $item->saveOrFail();


        $item->regions()->sync($createRequest->get('regions'));
        $item->spheres()->sync($createRequest->get('spheres'));
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
    public function changeStatus(Demand $item, $status)
    {
        if ($item->status !== $status) {
            $item->status = $status;
            $item->saveOrFail();
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


    public function isChangeAfterTimestamp(Company $company, Carbon $time)
    {
        $query = new DemandQuery();
        $query->forCompany($company->id)
            ->afterUpdatedAt($time);
        return $this->repo->count($query->getBuilder()) > 0;
    }


    public function onUpdate(Demand $item)
    {
        if ($item->isDirty('status') and $item->status == DemandStatus::ARCHIVED) {
            event(new ArchiveDemandEvent($item));
        }
    }

}