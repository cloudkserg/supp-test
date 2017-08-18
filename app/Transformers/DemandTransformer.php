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
use Swagger\Annotations as SWG;

/**
 *
 * @SWG\Definition(
 *      type="object",
 *      definition="DemandModel",
 *      @SWG\Property(
 *          property="id",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="title",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="status",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="created",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="desc",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="address",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="delivery_date",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="company",
 *          type="object",
 *          ref="#/definitions/CompanyModel"
 *      ),
 *      @SWG\Property(
 *          property="demandItems",
 *          type="array",
 *          @SWG\Items(ref="#/definitions/DemandItemModel")
 *      )
 * )
 * @SWG\Definition(
 *      definition="DemandModelWithResponses",
 *      @SWG\Property(
 *          property="id",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="number",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="title",
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
 *          property="demandItems",
 *          type="array",
 *          @SWG\Items(ref="#/definitions/DemandItemModel")
 *      ),
 *      @SWG\Property(
 *          property="responses",
 *          type="array",
 *          @SWG\Items(ref="#/definitions/ResponseModel")
 *      )
 * )
 * Class DemandTransformer
 * @package App\Transformers
 */
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
            'status' => $demand->status,
            'created' => $demand->created_at->toDateTimeString(),
            'number' => $demand->number,
            'desc' => $demand->desc,
            'address' => $demand->address,
            'delivery_date' => !empty($demand->delivery_date) ? $demand->delivery_date->toDateTimeString() : ''
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
        return $this->collection($demand->activeResponses, new ResponseTransformer());
    }


    /**
     *
     * @return $this
     */
    public function addActiveResponses()
    {
        $this->defaultIncludes[] = 'responses';
        return $this;
    }




}
