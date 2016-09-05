<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 16:39
 */

namespace App\Services;


use App\Http\Requests\EditRequest;
use App\Repository\RequestRepository;
use App\Type\RequestStatus;
use Dingo\Api\Http\Request;

class RequestService
{

    /**
     * @var RequestRepository
     */
    private $_repo;

    /**
     *
     */
    function __construct()
    {
        $this->_repo = new RequestRepository();
    }


    /**
     * @param $companyId
     * @return Request[]
     */
    public function getItems($companyId)
    {
        return $this->_repo->findAll($companyId);
    }

    /**
     * @param int $id
     * @param EditRequest $request
     * @param int $company_id
     * @return \App\Request\Request
     */
    public function editItem($id, EditRequest $request, $company_id)
    {
        $item = $this->_repo->findItem($id, $company_id);
        $item->attributes = $request->all();
        $item->save();

        return $item;
    }

    public function createItem(EditRequest $request, $company_id)
    {
        $item = new Request();
        $item->attributes = $request->all();
        $item->company_id = $company_id;
        $item->status = RequestStatus::CREATED;
        $item->save();

        return $item;
    }


    /**
     * @param int $id
     * @param int $companyId
     * @throws \Exception
     */
    public function deleteItem($id, $companyId)
    {
        $item = $this->_repo->findItem($id, $companyId);
        $item->delete();
    }

}