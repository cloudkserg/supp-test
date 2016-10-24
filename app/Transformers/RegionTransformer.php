<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 06.09.16
 * Time: 15:41
 */

namespace App\Transformers;

use App\Company;
use App\Type\Region;
use League\Fractal\TransformerAbstract;
use Swagger\Annotations as SWG;

/**
 * @SWG\Definition(
 *      definition="RegionModel",
 *      @SWG\Property(property="id", type="integer"),
 *      @SWG\Property(property="title", type="string")
 * )
 * Class CompanyTransformer
 * @package App\Transformers
 */
class RegionTransformer extends TransformerAbstract
{

    public function transform(Region $region)
    {
        return [
            'id' => (int)$region->id,
            'title' => $region->title
        ];
    }

}
