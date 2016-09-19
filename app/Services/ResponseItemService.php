<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 18:21
 */

namespace App\Services;

use App\Demand\Response;
use App\Demand\ResponseItem;
use App\Http\Requests\CreateResponseRequest;
use App\Http\Requests\UpdateResponseRequest;
use App\Type\ResponseItemStatus;


class ResponseItemService
{

    /**
     * @param Response $response
     * @param UpdateResponseRequest $request
     */
    public function addItems(Response $response, UpdateResponseRequest $request)
    {
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
     * @param ResponseItem $item
     * @param array $data
     */
    public function changeItem(ResponseItem $item, array $data)
    {
        $item->fill($data);
        $item->save();
    }

    /**
     * @param ResponseItem $item
     * @throws \Exception
     */
    public function deleteItem(ResponseItem $item)
    {
        $item->delete();
    }
}