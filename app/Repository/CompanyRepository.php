<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 15.09.16
 * Time: 13:46
 */

namespace App\Repository;


use App\Company;
use Illuminate\Database\Query\Builder;

class CompanyRepository
{

    /**
     * @param int $companyId
     * @param array $spheres
     * @param array $regions
     * @return mixed
     */
    public function countBySpheresAndRegionsWithoutMe($companyId, array $spheres, array $regions)
    {

        return  Company::whereHas('spheres', function ($q) use ($spheres) {
                    $q->whereIn('spheres.id', $spheres);
                })->whereHas('regions', function ($q) use ($regions) {
                    $q->whereIn('regions.id', $regions);
                })->where('companies.id', '!=', $companyId)
            ->count();


    }

}