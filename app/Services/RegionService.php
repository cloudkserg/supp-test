<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 17:27
 */

namespace App\Services;
use App\Type\Region;


class RegionService
{

    /**
     * @return Collection
     */
    public function getItems()
    {
        return Region::orderBy('title', 'asc')->get();
    }


}