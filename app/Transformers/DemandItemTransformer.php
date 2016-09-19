<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 06.09.16
 * Time: 14:19
 */

namespace App\Transformers;


use League\Fractal\TransformerAbstract;
use App\Demand\DemandItem;

class DemandItemTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [];


    public function transform(DemandItem $item)
    {
        return [
            'id' => (int)$item->id,
            'status' => $item->status,
            'quantityTitle' => isset($item->quantity) ? $item->quantity->title : null,
            'count' => (float)$item->count,
            'title' => $item->title
        ];
    }


}
