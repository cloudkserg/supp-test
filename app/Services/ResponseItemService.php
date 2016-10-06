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
        $responseItemData = collect($request->responseItems);
        $this->deleteNonExistantItems(
            $response->responseItems,
            $responseItemData->pluck('id')->toArray()
        );

        return $responseItemData->map(function ($data) use ($response) {
            $item = isset($data['id']) ? $this->findItem($data['id']) : new ResponseItem();

            $item->price = $data['price'];
            $item->demand_item_id = $data['demand_item_id'];
            $response->responseItems()->save($item);

            return $item;
        });
    }

    /**
     * @param Collection $items
     * @param array $ids
     */
    private function deleteNonExistantItems(Collection $items, array $ids)
    {
        $items->each(function(ResponseItem $item) use ($ids) {
            if (!in_array($item->id, $ids)) {
                $item->delete();
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