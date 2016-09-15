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

    protected $avalaiableIncludes = [
        'requestItem'
    ];

    protected $defaultIncludes = [
        'invoice'
    ];


    public function transform(ResponseItem $item)
    {
        return [
            'id' => (int)$item->id,
            'price' => $item->price
        ];
    }

    public function includeInvoice(ResponseItem $item)
    {
        return $this->item($item->invoice, new InvoiceTransformer());
    }

    public function includeDemandItem(ResponseItem $item)
    {
        return $this->collection($item->demandItem, new DemandItemTransformer());
    }


}
