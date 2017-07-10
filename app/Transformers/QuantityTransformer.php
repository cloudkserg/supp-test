<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 06.09.16
 * Time: 15:41
 */

namespace App\Transformers;

use App\Type\Quantity;
use League\Fractal\TransformerAbstract;
use Swagger\Annotations as SWG;

/**
 * @SWG\Definition(
 *      definition="QuantityModel",
 *      @SWG\Property(property="id", type="integer"),
 *      @SWG\Property(property="title", type="string")
 * )
 * Class QuantityTransformer
 * @package App\Transformers
 */
class QuantityTransformer extends TransformerAbstract
{

    public function transform(Quantity $quantity)
    {
        return [
            'id' => (int)$quantity->id,
            'title' => $quantity->title
        ];
    }

}
