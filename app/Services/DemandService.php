<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 16:39
 */

namespace App\Services;


use App\Http\Requests\CreateDemandRequest;
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
     * @param $companyId
     * @return Demand[]
     */
    public function getActiveItems($companyId)
    {
        return $this->_repo->findActiveByCompany($companyId);
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