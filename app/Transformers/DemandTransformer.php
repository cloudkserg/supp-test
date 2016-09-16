<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 06.09.16
 * Time: 14:19
 */

namespace App\Transformers;


use App\Demand\Demand;
use League\Fractal\TransformerAbstract;

class DemandTransformer extends TransformerAbstract
{
    /**
     * @var DemandItemTransformer
     */
    private $_demandItemTransformer;

    function __construct()
    {
        $this->_demandItemTransformer = new DemandItemTransformer();
    }


    protected $defaultIncludes = [
        'demandItems'
    ];

    public function transform(Demand $demand)
    {
        return [
            'id' => (int)$demand->id,
            'title' => $demand->title
        ];
    }

    public function includeCompany(Demand $demand)
    {
        return $this->item($demand->company, new CompanyTransformer());
    }

    public function includeDemandItems(Demand $demand)
    {
        return $this->collection($demand->demandItems, $this->_demandItemTransformer);
    }

    public function includeResponses(Demand $demand)
    {
        return $this->collection($demand->responses, new ResponseTransformer());
    }

    public function addCompany()
    {
        $this->defaultIncludes[] = 'company';
        return $this;
    }


    /**
     * @return $this
     */
    public function addResponses()
    {
        $this->defaultIncludes[] = 'responses';
        return $this;
    }


    /**
     * @return DemandItemTransformer
     */
    public function getDemandItemTransformer()
    {
        return $this->_demandItemTransformer;
    }



}
