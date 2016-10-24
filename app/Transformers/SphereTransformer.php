<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 06.09.16
 * Time: 15:41
 */

namespace App\Transformers;

use App\Type\Sphere;
use League\Fractal\TransformerAbstract;
use Swagger\Annotations as SWG;

/**
 * @SWG\Definition(
 *      definition="SphereModel",
 *      @SWG\Property(property="id", type="integer"),
 *      @SWG\Property(property="title", type="string")
 * )
 * Class CompanyTransformer
 * @package App\Transformers
 */
class SphereTransformer extends TransformerAbstract
{

    public function transform(Sphere $sphere)
    {
        return [
            'id' => (int)$sphere->id,
            'title' => $sphere->title
        ];
    }

}
