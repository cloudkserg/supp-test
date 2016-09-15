<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 16:40
 */

namespace App\Repository;
use App\Demand\Demand;
use App\Type\DemandStatus;

class DemandRepository
{
    /**
     * @param $companyId
     * @return Demand[]
     */
    public function findActiveByCompany($companyId)
    {
        return Demand::whereCompanyId($companyId)
            ->whereStatus(DemandStatus::ACTIVE)
            ->get();
    }


}