<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 16:39
 */

namespace App\Services;



use App\Events\Demand\ArchiveDemandEvent;
use App\Events\Demand\CancelDemandEvent;
use App\Events\Demand\DeleteDemandEvent;
use App\Events\Demand\DoneDemandEvent;
use App\Helpers\ModelHelper;
use App\Http\Requests\UpdateDemandRequest;
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


    /**
     * @param int $companyId
     * @return int
     */
    private function generateNumber($companyId)
    {

        $numberString = $this->repo->findLastNumberForCompanyId($companyId);
        $number = filter_var($numberString, FILTER_SANITIZE_NUMBER_INT);
        return ++$number;
    }


    public function addItem($companyId, CreateDemandRequest $createRequest)
    {
        $item = new Demand();
        $item->fill($createRequest->all());
        (new ModelHelper())->copyParams($item, [
            'addition_emails' => $createRequest->additionEmails,
            'delivery_date' => $createRequest->getDeliveryDate(),
            'company_id' => $companyId,
            'status' => DemandStatus::ACTIVE
        ]);
        if (empty($item->number)) {
            $item->number = $this->generateNumber($companyId);
        }
        $item->saveOrFail();


        $item->regions()->sync($createRequest->get('regions'));
        $item->spheres()->sync($createRequest->get('spheres'));
        return $item;
    }

    public function activeItem(Demand $demand)
    {
        $demand->status  = DemandStatus::ACTIVE;
        $demand->saveOrFail();
    }

    public function cancelItem(Demand $demand)
    {
        $demand->status = DemandStatus::CANCEL;
        $demand->saveOrFail();

        event(new CancelDemandEvent($demand));
    }

    public function doneItem(Demand $demand)
    {
        $demand->status = DemandStatus::DONE;
        $demand->saveOrFail();

        event(new DoneDemandEvent($demand));
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
     * @param UpdateDemandRequest $request
     */
    public function changeItem(Demand $item, UpdateDemandRequest $request)
    {
        $item->number = $request->get('number');
        if ($item->status !== $request->get('status')) {
            $item->status = $request->get('status');
        }
        $item->saveOrFail();
    }

    /**
     * @param Demand $item
     */
    public function delete(Demand $item)
    {
        $item->status = DemandStatus::DELETED;
        $item->saveOrFail();

        event(new DeleteDemandEvent($item));
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


}