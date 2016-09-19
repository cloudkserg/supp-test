<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 15.09.16
 * Time: 20:37
 */

namespace App\Queries;


use App\Company;
use App\Demand\Demand;
use Illuminate\Database\Eloquent\Builder;

class CompanyQuery
{

    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;

    public function __construct()
    {
        $this->builder = Company::query();
    }

    /**
     * @param int $companyId
     * @return $this
     */
    public function forNotCompany($companyId)
    {
        $this->builder->where('companies.id', '!=', $companyId);
        return $this;
    }

    /**
     * @param mixed|null $inputRegion
     * @return $this
     */
    public function forRegion($inputRegion)
    {
        $region = is_array($inputRegion) ? $inputRegion : array($inputRegion);
        $this->builder->whereHas('regions', function (Builder $q) use ($region) {
            $q->whereIn('regions.id', $region);
        });
        return $this;
    }
    /**
     * @param mixed|null $inputSphere
     * @return $this
     */
    public function forSphere($inputSphere)
    {
        $sphere = is_array($inputSphere) ? $inputSphere : array($inputSphere);
        $this->builder->whereHas('spheres', function (Builder $q) use ($sphere) {
            $q->whereIn('spheres.id', $sphere);
        });
        return $this;
    }

    /**
     * @param int $demandId
     * @return $this
     */
    public function hasNotResponses($demandId)
    {
        $this->builder->whereDoesntHave('responses', function (Builder $q) use ($demandId) {
            $q->where('demand_id', $demandId);
        });
        return $this;
    }



    /**
     * @return Builder
     */
    public function getBuilder()
    {
        return $this->builder;
    }




}