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
use App\Events\DemandItem\SelectedResponseItemEvent;
use App\Events\DemandItem\UnselectedResponseItemEvent;
use App\Http\Requests\CreateDemandRequest;

class DemandItemService
{

    /**
     * @param Demand $demand
     * @param CreateDemandRequest $createRequest
     */
    public function addItems(Demand $demand, CreateDemandRequest $createRequest)
    {
        foreach ($createRequest->demandItems as $demandItemData) {
            $demandItem = new DemandItem();
            $demandItem->title = $demandItemData['title'];
            $demandItem->count = $demandItemData['count'];
            $demandItem->quantity_id = $demandItemData['quantityId'];

            $demandItem->demand_id = $demand->id;
            $demandItem->saveOrFail();
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

    public function onUpdate(DemandItem $item)
    {
        if ($item->isDirty('response_item_id')) {
            if (isset($item->response_item_id)) {
                event(new SelectedResponseItemEvent($item));
            } else {
                $this->generateUnselectedEvent($item);

            }
        }
    }

    private function generateUnselectedEvent(DemandItem $item)
    {
        $responseItem = $item->getOrdinalSelectedResponseItem();
        if (isset($responseItem)) {
            event(new UnselectedResponseItemEvent($item, $responseItem));
        }
    }

}