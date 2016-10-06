<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 06.09.16
 * Time: 15:41
 */

namespace App\Transformers;

use App\Company;
use League\Fractal\TransformerAbstract;
use Swagger\Annotations as SWG;

/**
 * @SWG\Definition(
 *      definition="CompanyModel",
 *      @SWG\Property(property="id", type="integer"),
 *      @SWG\Property(property="title", type="string")
 * )
 * Class CompanyTransformer
 * @package App\Transformers
 */
class CompanyTransformer extends TransformerAbstract
{

    public function transform(Company $company)
    {
        return [
            'id' => (int)$company->id,
            'title' => $company->title
        ];
    }

}
