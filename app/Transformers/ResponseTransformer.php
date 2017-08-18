<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 06.09.16
 * Time: 14:19
 */

namespace App\Transformers;


use App\Demand\Response;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Swagger\Annotations as SWG;

/**
/**

 * @SWG\Definition(
 *      definition="ResponseModel",
 *      @SWG\Property(
 *          property="id",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="demand_id",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="number",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="delivery_type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="status",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="company",
 *          type="object",
 *          ref="#/definitions/CompanyModel"
 *      ),
 *      @SWG\Property(
 *          property="invoices",
 *          type="array",
 *          @SWG\Items(ref="#/definitions/InvoiceModel")
 *      ),
 *      @SWG\Property(
 *          property="responseItems",
 *          type="array",
 *          @SWG\Items(ref="#/definitions/ResponseItemModel")
 *      )
 * )
 * @SWG\Definition(
 *      definition="ResponseModelWithDemand",
 *      @SWG\Property(
 *          property="id",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="demand_id",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="delivery_type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="number",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="desc",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="readed",
 *          type="string",
 *          description="datetime"
 *      ),
 *      @SWG\Property(
 *          property="status",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="company",
 *          type="object",
 *          ref="#/definitions/CompanyModel"
 *      ),
 *      @SWG\Property(
 *          property="invoices",
 *          type="array",
 *          @SWG\Items(ref="#/definitions/InvoiceModel")
 *      ),
 *      @SWG\Property(
 *          property="responseItems",
 *          type="array",
 *          @SWG\Items(ref="#/definitions/ResponseItemModel")
 *      ),
 *      @SWG\Property(
 *          property="demand",
 *          ref="#/definitions/DemandModel"
 *      )
 * )
 * Class ResponseTransformer
 * @package App\Transformers
 */
class ResponseTransformer extends TransformerAbstract
{

    protected $defaultIncludes = [
        'company', 'responseItems', 'invoices'
    ];



    public function transform(Response $response)
    {
        return [
            'id' => (int)$response->id,
            'number' => $response->number,
            'demand_id' => (int)$response->demand_id,
            'status' => $response->status,
            'delivery_type' => $response->delivery_type,
            'desc' => $response->desc,
            'readed' => isset($response->readed_time) ? $response->readed_time : Carbon::parse($response->readed_time)->toDateTimeString()
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

    public function includeInvoices(Response $response)
    {
        return $this->collection($response->invoices, new InvoiceTransformer());
    }

    public function includeResponseItems(Response $response)
    {
        return $this->collection($response->responseItems, new ResponseItemTransformer());
    }

    /**
     *
     * @return $this
     */
    public function addDemand()
    {
        $this->defaultIncludes[] = 'demand';
        return $this;
    }


}
