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

    protected $defaultIncludes = [
        'demandItems', 'company'
    ];

    public function transform(Demand $demand)
    {
        return [
            'id' => (int)$demand->id,
            'title' => $demand->title,
            'status' => $demand->status
        ];
    }

    public function includeCompany(Demand $demand)
    {
        return $this->item($demand->company, new CompanyTransformer());
    }

    public function includeDemandItems(Demand $demand)
    {
        return $this->collection($demand->demandItems, new DemandItemTransformer());
    }

    public function includeResponses(Demand $demand)
    {
        return $this->collection($demand->responses, new ResponseTransformer());
    }


    /**
     * @return $this
     */
    public function addResponses()
    {
        $this->defaultIncludes[] = 'responses';
        return $this;
    }




}
