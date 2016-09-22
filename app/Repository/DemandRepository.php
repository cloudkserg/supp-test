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
     * @param Builder $builder
     * @return Collection|static[]
     */
    public function findAll(Builder $builder)
    {
        return $builder->orderBy('id', 'DESC')->get();
    }

    /**
     * @param int $demandId
     * @return Demand
     */
    public function findById($demandId)
    {
        return Demand::whereId($demandId)->first();
    }

    public function count(Builder $builder)
    {
        return $builder->count();
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
