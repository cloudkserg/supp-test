<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 15.09.16
 * Time: 20:58
 */

namespace App\Queries;


use Illuminate\Database\Eloquent\Collection;

class DemandRelationLoader
{

    private $loads = [];


    /**
     * @param int $companyId
     * @return $this
     */
    public function loadResponsesForCompany($companyId)
    {
        $this->loads['responses'] = function ($q) use ($companyId) {
            $q->whereCompanyId($companyId);
        };
        return $this;
    }

    /**
     * @param int $companyId
     * @return $this
     */
    public function loadResponseItemsForCompany($companyId)
    {
        $this->loads['demandItems.responseItems'] = function ($q) use ($companyId) {
            $q->whereHas('response', function ($b) use ($companyId) {
                $b->whereCompanyId($companyId);
            });
        };
    }

    /**
     * @param int $companyId
     * @return $this
     */
    public function loadSelectedResponseItemForCompany($companyId)
    {
        $this->loads['demandItems.selectedResponseItem'] = function ($q) use ($companyId) {
            $q->whereHas('response', function ($b) use ($companyId) {
                $b->whereCompanyId($companyId);
            });
        };
        return $this;
    }


    /**
     * @param Collection $items
     */
    public function applyLoad(Collection $items)
    {
        $items->load($this->loads);
    }


}