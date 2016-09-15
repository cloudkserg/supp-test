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
