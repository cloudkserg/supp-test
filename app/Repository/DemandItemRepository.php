<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 16:40
 */

namespace App\Repository;
use App\Demand\Demand;
use App\Demand\DemandItem;
use App\Type\DemandStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

class DemandItemRepository
{

    public function getMaxUpdatedByDemandId($demandId)
    {
        return DemandItem::whereDemandId($demandId)
            ->select('');
    }
}