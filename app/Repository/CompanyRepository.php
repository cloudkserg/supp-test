<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 15.09.16
 * Time: 13:46
 */

namespace App\Repository;


use App\Company;
use Illuminate\Database\Eloquent\Builder;

class CompanyRepository
{


    /**
     * @param Builder $builder
     * @return int
     */
    public function count(Builder $builder)
    {
        return $builder->count();
    }

    /**
     * @param Builder $builder
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findAll(Builder $builder)
    {
        return $builder->get();
    }

}