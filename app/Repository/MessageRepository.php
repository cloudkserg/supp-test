<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 16:40
 */

namespace App\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

class MessageRepository
{
    /**
     * @param Builder $builder
     * @return Collection|static[]
     */
    public function findAll(Builder $builder, $limit)
    {
        return $builder->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->get();
    }

}
