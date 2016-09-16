<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 16:39
 */

namespace App\Services;


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
    private $_repo;

    /**
     *
     */
    function __construct()
    {
        $this->_repo = new DemandRepository();
    }


    /**
     * @param Company $company
     * @return Collection
     */
    public function getActiveItems(Company $company)
    {
        return $this->_repo->findActiveByCompany($company->id);
    }

    /**
     * @param Company $company
     * @return Collection
     */
    public function getInputItems(Company $company)
    {
        return $this->_repo->findActiveBySpheresAndRegions(
                $company->spheres->pluck('id')->toArray(),
                $company->regions->pluck('id')->toArray(),
                (new DemandQuery())->withoutCompanyItems($company->id)
                    ->getBuilder()
            );
    }

    /**
     * @param Company $company
     * @param Collection $demands
     * @return Collection
     */
    public function loadOnlyMyResponses(Company $company, Collection $demands)
    {
        $loader = new DemandRelationLoader();
        $loader->loadSelectedResponseItemForCompany($company->id)
            ->loadResponsesForCompany($company->id)
            ->loadResponseItemsForCompany($company->id);
        $loader->applyLoad($demands);

        return $demands;
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


}