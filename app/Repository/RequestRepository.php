<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 16:40
 */

namespace App\Repository;
use App\Request\Request;

class RequestRepository
{
    /**
     * @param $companyId
     * @return Request[]
     */
    public function findAll($companyId)
    {
        return Request::whereCompanyId($companyId)->get();
    }

    /**
     * @param int $id
     * @param int $company_id
     * @return Request
     */
    public function findItem($id, $companyId)
    {
        return Request::whereCompanyId($companyId)->findOrFail($id);
    }

}