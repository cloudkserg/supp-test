<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 16:39
 */

namespace App\Services;


use App\Company;
use App\Demand\Demand;
use App\Events\Response\ActiveResponseEvent;
use App\Events\Response\ArchiveResponseEvent;
use App\Events\Response\CancelResponseEvent;
use App\Events\Response\ChangeResponseEvent;
use App\Events\Response\CreateResponseEvent;
use App\Http\Requests\UpdateResponseRequest;
use App\Queries\ResponseQuery;
use App\Repository\ResponseRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

use App\Type\ResponseStatus;
use App\Demand\Response;

class ResponseService
{


    /**
     * @var ResponseRepository
     */
    private $repo;



    function __construct()
    {
        $this->repo = new ResponseRepository();
    }

    /**
     * @param Company $company
     * @param array|string $status
     * @return Collection
     */
    public function getItemsByCompanyAndStatus(Company $company, $status)
    {
        $query = new ResponseQuery();
        $query->forCompany($company->id);
        $query->forStatus($status);

        return $this->repo->findAll($query->getBuilder());
    }


    /**
     * @param $companyId
     * @param $demandId
     * @return Response
     */
    public function addItem($companyId, $demandId)
    {
        $item = new Response();
        $item->company_id = $companyId;
        $item->demand_id = $demandId;
        $item->status = ResponseStatus::DRAFT;
        $item->saveOrFail();
        return $item;
    }

    /**
     * @param int $id
     * @return Demand
     */
    public function findItem($id)
    {
        return Response::whereId($id)->first();
    }

    /**
     * @param Response $item
     * @param UpdateResponseRequest $request
     * @return Response
     */
    public function changeItem(Response $item, UpdateResponseRequest $request)
    {
        $item->fill($request->all());
        $item->saveOrFail();
        return $item;
    }

    public function isChangeAfterTimestamp(Company $company, Carbon $time)
    {
        $query = new ResponseQuery();
        $query->forCompany($company->id)
            ->afterUpdatedAt($time);
        return $this->repo->count($query->getBuilder()) > 0;
    }


    /**
     * @param Response $item
     */
    public function onCreate(Response $item)
    {
        event(new CreateResponseEvent($item));
    }

    /**
     * @param Response $item
     */
    public function onUpdate(Response $item)
    {
        if ($item->isDirty('status')) {
            $this->generateEventStatus($item, $item->status);
        }
        if ($item->isDirty(['delivery_type'])) {
            event(new ChangeResponseEvent($item, $item->getOriginal('delivery_type')));
        }
    }


    /**
     * @param Response $item
     * @param $status
     */
    private function generateEventStatus(Response $item, $status)
    {
        switch($status) {
            case ResponseStatus::ACTIVE:
                event(new ActiveResponseEvent($item));
                break;
            default:
                if ($item->getOriginal('status') == ResponseStatus::ACTIVE) {
                    event(new CancelResponseEvent($item));
                }
                break;
        }
    }


}