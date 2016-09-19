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


    protected $defaultIncludes = [
        'invoice'
    ];


    public function transform(ResponseItem $item)
    {
        return [
            'id' => (int)$item->id,
            'price' => $item->price,
            'status' => $item->status,
            'demand_item_id' => (int)$item->demand_item_id
        ];
    }

    public function includeInvoice(ResponseItem $item)
    {
        if (!isset($item->invoice)) {
            return null;
        }
        return $this->item($item->invoice, new InvoiceTransformer());
    }


}
