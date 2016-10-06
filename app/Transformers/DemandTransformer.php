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
     *
     * @return $this
     */
    public function addResponses()
    {
        $this->defaultIncludes[] = 'responses';
        return $this;
    }




}
