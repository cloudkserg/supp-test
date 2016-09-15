<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 06.09.16
 * Time: 14:19
 */

namespace App\Transformers;


use App\Demand\Demand;
use League\Fractal\TransformerAbstract;

class DemandTransformer extends TransformerAbstract
{


    protected $defaultIncludes = [
        'demandItems'
    ];

    public function transform(Demand $demand)
    {
        return [
            'id' => (int)$demand->id,
            'title' => $demand->title
        ];
    }

    public function includeDemandItems(Demand $demand)
    {
        return $this->collection($demand->demandItems, new DemandItemTransformer());
    }



}
