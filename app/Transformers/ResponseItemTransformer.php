<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 06.09.16
 * Time: 14:19
 */

namespace App\Transformers;


use League\Fractal\TransformerAbstract;
use App\Demand\ResponseItem;

class ResponseItemTransformer extends TransformerAbstract
{


    public function transform(ResponseItem $item)
    {
        return [
            'id' => (int)$item->id,
            'price' => $item->price,
            'status' => $item->status,
            'demand_item_id' => (int)$item->demand_item_id,
            'invoice_id' => isset($item->invoice_id) ? (int)$item->invoice_id : null
        ];
    }


}
