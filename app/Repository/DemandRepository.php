<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 16:40
 */

namespace App\Repository;
use App\Demand\Demand;
use App\Type\DemandStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

class DemandRepository
{
    /**
     * @param $companyId
     * @return Demand[]
     */
    public function findActiveByCompany($companyId)
    {
        return Demand::whereCompanyId($companyId)
            ->whereStatus(DemandStatus::ACTIVE)
            ->get();
    }




    /**
     * @param array $spheres
     * @param array $regions
     * @param Builder $builder
     * @return Collection
     */
    public function findActiveBySpheresAndRegions(array $spheres,array $regions, Builder $builder = null)
    {
        return $this->initBuilder($builder)->whereStatus(DemandStatus::ACTIVE)
            ->whereHas('spheres', function ($q) use ($spheres) {
                $q->whereIn('spheres.id', $spheres);
            })->whereHas('regions', function ($q) use ($regions) {
                $q->whereIn('regions.id', $regions);
            })->get();
    }


    /**
     * @param Builder $builder
     * @return Builder
     */
    private function initBuilder(Builder $builder = null)
    {
        return isset($builder) ? $builder : Demand::query();
    }
}