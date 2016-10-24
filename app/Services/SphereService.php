<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 17:27
 */

namespace App\Services;
use App\Type\Sphere;


class SphereService
{

    /**
     * @return Collection
     */
    public function getItems()
    {
        return Sphere::orderBy('title', 'asc')->get();
    }


}