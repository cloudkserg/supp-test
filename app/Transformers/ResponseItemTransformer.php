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
use Swagger\Annotations as SWG;

/**
 *
 * @SWG\Definition(
 *      definition="ResponseItemModel",
 *      @SWG\Property(
 *          property="id",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="response_id",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="price",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="status",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="selected",
 *          type="boolean"
 *      ),
 *      @SWG\Property(
 *          property="invoice_id",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="demand_item_id",
 *          type="integer"
 *      ),
 * )
 *
 * Class ResponseItemTransformer
 * @package App\Transformers
 */
class ResponseItemTransformer extends TransformerAbstract
{


    public function transform(ResponseItem $item)
    {
        return [
            'id' => (int)$item->id,
            'price' => $item->price,
            'status' => $item->status,
            'selected' => (bool)$item->isSelected(),
            'response_id' => (int)$item->response_id,
            'demand_item_id' => (int)$item->demand_item_id,
            'invoice_id' => isset($item->invoice_id) ? (int)$item->invoice_id : null
        ];
    }


}
