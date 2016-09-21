<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 16:40
 */

namespace App\Repository;
use App\Demand\Response;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

class ResponseRepository
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
     * @return Response
     */
    public function findById($demandId)
    {
        return Response::whereId($demandId)->first();
    }




}
