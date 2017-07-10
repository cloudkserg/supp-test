<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 17:27
 */

namespace App\Services;
use App\Type\Quantity;

use Illuminate\Database\Eloquent\Collection;

class QuantityService
{

    /**
     * @return Collection
     */
    public function getItems()
    {
        return Quantity::orderBy('title', 'asc')->get();
    }


}