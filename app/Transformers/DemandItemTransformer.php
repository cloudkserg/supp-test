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
use Swagger\Annotations as SWG;

/**
 * @SWG\Definition(
 *      definition="DemandItemModel",
 *      @SWG\Property(property="id",type="integer"),
 *      @SWG\Property(property="status",type="string"),
 *      @SWG\Property(property="demandId",type="integer"),
 *      @SWG\Property(property="quantityTitle", type="string", description="string or null"),
 *      @SWG\Property(property="count", type="number"),
 *      @SWG\Property(property="title", type="string")
 * )
 * Class DemandItemTransformer
 * @package App\Transformers
 */
class DemandItemTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [];


    public function transform(DemandItem $item)
    {
        return [
            'id' => (int)$item->id,
            'status' => $item->status,
            'demandId' => $item->demand_id,
            'quantityTitle' => isset($item->quantity) ? $item->quantity->title : null,
            'count' => (float)$item->count,
            'title' => $item->title
        ];
    }


}
