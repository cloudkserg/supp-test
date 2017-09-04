<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 18:21
 */

namespace App\Services;

use App\Demand\Invoice;
use App\Demand\Response;
use App\Demand\ResponseItem;
use App\Events\ResponseItem\DeleteResponseItemEvent;
use App\Http\Requests\UpdateResponseRequest;
use Illuminate\Support\Collection;
use App\Events\ResponseItem\ChangeResponseItemEvent;

class ResponseItemService
{
    /**
     * @param Response $response
     * @param UpdateResponseRequest $request
     * @return array
     */
    public function createItemsForResponse(Response $response, UpdateResponseRequest $request)
    {
        $newResponseItems = collect($request->responseItems);
        $oldResponseItems = $response->responseItems;

        $this->deleteNonExistantItems($oldResponseItems, $newResponseItems);
        return  $newResponseItems->map(function ($newItemData) use ($response) {
            return $this->createNewItem($newItemData, $response);
        });
    }

    /**
     * @param array $newItemData
     * @param Response $response
     * @return ResponseItem
     */
    private function createNewItem(array $newItemData, Response $response)
    {
        $item = isset($newItemData['id']) ? $this->findItem($newItemData['id']) : new ResponseItem();

        $item->price = $newItemData['price'];
        $item->demand_item_id = $newItemData['demandItemId'];
        $response->responseItems()->save($item);

        return $item;
    }

    /**
     * @param Collection $oldItems
     * @param Collection $newItems
     */
    private function deleteNonExistantItems(Collection $oldItems, Collection $newItems)
    {
        $newIds = $newItems->pluck('id')->toArray();
        $oldItems->each(function(ResponseItem $oldItem) use ($newIds) {
            if (!in_array($oldItem->id, $newIds)) {
                $oldItem->delete();
            }
        });
    }

    /**
     * @param $id
     * @return ResponseItem
     */
    public function findItem($id)
    {
        return ResponseItem::findOrFail($id);
    }

    /**
     * @param $id
     * @return ResponseItem[]
     */
    public function findItems($id)
    {
        return ResponseItem::whereIn('id', $id)->get();
    }


    /**
     * @param ResponseItem $item
     * @param array $data
     */
    public function changeItem(ResponseItem $item, array $data)
    {
        $item->fill($data);
        $item->saveOrFail();
    }

    /**
     * @param ResponseItem $item
     * @throws \Exception
     */
    public function deleteItem(ResponseItem $item)
    {
        $item->delete();
    }


    /**
     * @param ResponseItem $responseItem
     * @param int $invoiceId
     */
    public function setInvoice(ResponseItem $responseItem, $invoiceId)
    {
        $responseItem->invoice_id = $invoiceId;
        $responseItem->saveOrFail();
    }


    /**
     * @param ResponseItem $item
     */
    public function onDelete(ResponseItem $item)
    {
        event(new DeleteResponseItemEvent($item));
    }

    /**
     * @param ResponseItem $item
     */
    public function onUpdate(ResponseItem $item)
    {
        if ($item->isDirtyPrice()) {
            event(new ChangeResponseItemEvent($item, $item->getOriginalPrice()));
        }
    }

}