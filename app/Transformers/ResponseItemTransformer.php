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
 *          property="responseId",
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
 *          property="invoiceId",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="demandItemId",
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
            'responseId' => (int)$item->response_id,
            'demandItemId' => (int)$item->demand_item_id,
            'invoiceId' => isset($item->invoice_id) ? (int)$item->invoice_id : null
        ];
    }


}
