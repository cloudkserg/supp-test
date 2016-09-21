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
use App\Http\Requests\CreateInvoiceRequest;
use App\Http\Requests\CreateResponseRequest;
use App\Http\Requests\UpdateResponseRequest;
use App\Type\ResponseItemStatus;
use Illuminate\Support\Collection;


class ResponseItemService
{

    /**
     * @param Response $response
     * @param UpdateResponseRequest $request
     */
    public function changeItemsForResponse(Response $response, UpdateResponseRequest $request)
    {
        $this->deleteItemsForResponse($response);
        foreach ($request->responseItems as $responseItemData) {
            $responseItem = new ResponseItem();
            $responseItem->price = $responseItemData['price'];
            $responseItem->demand_item_id = $responseItemData['demand_item_id'];
            $response->responseItems()->save($responseItem);
        }
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
     * @param Response $item
     * @throws \Exception
     */
    public function deleteItemsForResponse(Response $item)
    {
        foreach ($item->responseItems as $item) {
            $item->delete();
        }
    }

    /**
     * @param Invoice $invoice
     * @param Collection $responseItems
     */
    public function addInvoice(Invoice $invoice, Collection $responseItems)
    {
        $responseItems->each(function (ResponseItem $responseItem) use ($invoice) {
            $responseItem->invoice_id = $invoice->id;
            $responseItem->saveOrFail();
        });
    }
}