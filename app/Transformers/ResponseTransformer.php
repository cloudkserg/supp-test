<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 06.09.16
 * Time: 14:19
 */

namespace App\Transformers;


use App\Demand\Response;
use League\Fractal\TransformerAbstract;

class ResponseTransformer extends TransformerAbstract
{

    protected $defaultIncludes = [
        'company'
    ];



    public function transform(Response $response)
    {
        return [
            'id' => (int)$response->id,
            'status' => $response->status,
            'delivery_type_title' => isset($response->deliveryType) ? $response->deliveryType->title : null
        ];
    }

    public function includeDemand(Response $response)
    {
        return $this->item($response->demand, new DemandTransformer());
    }

    public function includeCompany(Response $response)
    {
        return $this->item($response->company, new CompanyTransformer());
    }

    public function includeResponseItems(Response $response)
    {
        return $this->collection($response->responseItems, new ResponseItemTransformer());
    }

    public function addDemand()
    {
        $this->defaultIncludes[] = 'demand';
    }

    public function addResponseItems()
    {
        $this->defaultIncludes[] = 'responseItems';
    }


}
