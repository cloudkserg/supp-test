<?php

namespace App\Http\Controllers;

use App\Services\DemandItemService;
use App\Services\DemandService;
use Dingo\Api\Routing\Helpers;

use App\User;
use App\Company;
use App\Http\Requests;
use App\Transformers\DemandTransformer;
use App\Http\Requests\CreateDemandRequest;
use Illuminate\Http\Request;
use League\Fractal\Resource\Collection;


class DemandsController extends Controller
{

    use Helpers;

    /**
     * @var DemandService
     */
    private $_demandService;

    /**
     * @var DemandItemService
     */
    private $_demandItemService;


    /**
     *
     */
    function __construct()
    {
        $this->_demandService = new DemandService();
        $this->_demandItemService = new DemandItemService();
    }

    /**
     * @return User
     */
    private function getUser()
    {
        return $this->auth->user();
    }

    /**
     * @return Company
     */
    private function getCompany()
    {
        return $this->getUser()->company;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexActive()
    {
        $transformer = (new DemandTransformer())
            ->addResponses();
        $transformer->getDemandItemTransformer()
            ->addSelectedResponseItem()
            ->addResponseItems();

        $items = $this->_demandService->getActiveItems($this->getCompany());
        return $this->response->collection($items, $transformer);

    }

    public function indexInput()
    {
        $transformer = (new DemandTransformer())
            ->addResponses()
            ->addCompany();
        $transformer->getDemandItemTransformer()
            ->addSelectedResponseItem()
            ->addResponseItems();

        $items = $this->_demandService->getInputItems($this->getCompany());
        $this->_demandService->loadOnlyMyResponses($this->getCompany(), $items);

        return $this->response->collection($items, $transformer);
    }

    public function store(CreateDemandRequest $createRequest)
    {
        $demand = $this->_demandService->addItem($this->getCompany()->id, $createRequest);
        $this->_demandItemService->addItems($demand, $createRequest);
        return $this->response->created('/demands/' . $demand->id);
    }

}
