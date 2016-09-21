<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 18:21
 */

namespace App\Services;

use App\Demand\Demand;
use App\Demand\DemandItem;
use App\Http\Requests\CreateDemandRequest;
use App\Type\DemandItemStatus;

class DemandItemService
{

    /**
     * @param Demand $demand
     * @param CreateDemandRequest $createRequest
     */
    public function addItems(Demand $demand, CreateDemandRequest $createRequest)
    {
        foreach ($createRequest->demandItems as $demandItemData) {
            $demandItem = new DemandItem($demandItemData);
            $demand->demandItems()->saveOrFail($demandItem);
        }
    }

    /**
     * @param $id
     * @return DemandItem
     */
    public function findItem($id)
    {
        return DemandItem::findOrFail($id);
    }


    /**
     * @param DemandItem $item
     * @param $responseItemId
     */
    public function selectResponseItem(DemandItem $item, $responseItemId)
    {
        $item->response_item_id = $responseItemId;
        $item->saveOrFail();
    }


    /**
     * @param DemandItem $item
     */
    public function unselectResponseItem(DemandItem $item)
    {
        $item->response_item_id = null;
        $item->saveOrFail();
    }

}