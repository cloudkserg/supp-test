<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 15.09.16
 * Time: 20:37
 */

namespace App\Queries;


use App\Demand\Demand;
use Illuminate\Database\Eloquent\Builder;

class DemandQuery
{

    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;

    public function __construct()
    {
        $this->builder = Demand::query();
    }

    /**
     * @param int $companyId
     * @return $this
     */
    public function forCompany($companyId)
    {
        $this->builder->whereCompanyId($companyId);
        return $this;
    }

    /**
     * @param string|array $inputStatus
     * @return $this
     */
    public function forStatus($inputStatus)
    {
        $status = is_array($inputStatus) ? $inputStatus : array($inputStatus);
        $this->builder->whereIn('status', $status);
        return $this;
    }


    /**
     * @param mixed|null $inputSphere
     * @return $this
     */
    public function forSphere($inputSphere)
    {
        $spheres = is_array($inputSphere) ? $inputSphere : array($inputSphere);
        $this->builder->whereHas('spheres', function (Builder $q) use ($spheres) {
            return $q->whereIn('spheres.id', $spheres);
        });
        return $this;
    }

    /**
     * @param mixed|null $inputRegion
     * @return $this
     */
    public function forRegion($inputRegion)
    {
        $regions = is_array($inputRegion) ? $inputRegion : array($inputRegion);
        $this->builder->whereHas('regions', function (Builder $q) use ($regions) {
            return $q->whereIn('regions.id', $regions);
        });
        return $this;
    }

    /**
     * @param int $companyId
     * @return $this
     */
    public function forNotCompanyResponse($companyId)
    {
        $this->builder->whereDoesntHave('responses', function (Builder $q) use ($companyId) {
            return $q->where('responses.company_id',  $companyId);
        });
        return $this;
    }

    /**
     * @param int $companyId
     * @return $this
     */
    public function forNotCompany($companyId)
    {
        $this->builder->where('company_id', '!=', $companyId);
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