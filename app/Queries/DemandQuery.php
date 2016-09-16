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
    private $builder;

    public function __construct()
    {
        $this->builder = Demand::query();
    }



    public function withoutCompanyItems($companyId)
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