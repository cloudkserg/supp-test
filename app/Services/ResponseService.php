<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 16:39
 */

namespace App\Services;


use App\Company;
use App\Demand\Demand;
use App\Http\Requests\UpdateResponseRequest;
use App\Queries\ResponseQuery;
use App\Repository\ResponseRepository;
use Illuminate\Database\Eloquent\Collection;

use App\Type\ResponseStatus;
use App\Demand\Response;

class ResponseService
{


    /**
     * @var ResponseRepository
     */
    private $repo;



    function __construct()
    {
        $this->repo = new ResponseRepository();
    }

    /**
     * @param Company $company
     * @param array|string $status
     * @return Collection
     */
    public function getItemsByCompanyAndStatus(Company $company, $status)
    {
        $query = new ResponseQuery();
        $query->forCompany($company->id);
        $query->forStatus($status);

        return $this->repo->findAll($query->getBuilder());
    }


    /**
     * @param $companyId
     * @param $demandId
     * @return Response
     */
    public function addItem($companyId, $demandId)
    {
        $item = new Response();
        $item->company_id = $companyId;
        $item->demand_id = $demandId;
        $item->status = ResponseStatus::DRAFT;
        $item->saveOrFail();
        return $item;
    }

    /**
     * @param int $id
     * @return Demand
     */
    public function findItem($id)
    {
        return Response::whereId($id)->first();
    }

    /**
     * @param Response $item
     * @param UpdateResponseRequest $request
     */
    public function changeItem(Response $item, UpdateResponseRequest $request)
    {
        $item->fill($request->all());
        $item->saveOrFail();
    }


}