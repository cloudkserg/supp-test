<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 13.09.16
 * Time: 16:24
 */

namespace App\Http\Requests;


use App\Http\Requests\ApiRequest;
use Carbon\Carbon;
use Swagger\Annotations as SWG;


/**
 *
 * @SWG\Definition(
 *      definition="CreateDemandRequest",
 *      required={"demandItems"},
 *      @SWG\Property(
 *         property="title",
 *         description="title demand",
 *         type="string",
 *      ),
 *      @SWG\Property(
 *         property="address",
 *         description="address demand",
 *         type="string",
 *      ),
 *      @SWG\Property(
 *         property="desc",
 *         description="description of demand",
 *         type="string",
 *      ),
 *      @SWG\Property(
 *         property="delivery_date",
 *         description="date delivery of demand(dd.mm.YYYY)",
 *         type="string",
 *      ),
 *      @SWG\Property(
 *         property="addition_emails",
 *         description="addition emails",
 *         type="array",
 *         @SWG\Items(type="string", description="email")
 *      ),
 *      @SWG\Property(
 *         property="regions",
 *         description="regions",
 *         type="array",
 *         @SWG\Items(type="string", description="region")
 *      ),
 *      @SWG\Property(
 *         property="spheres",
 *         description="spheres",
 *         type="array",
 *         @SWG\Items(type="string", description="sphere")
 *      ),
 *      @SWG\Property(
 *         property="demandItems",
 *         description="demandItems",
 *         type="array",
 *         @SWG\Items(
 *              type="object",
 *              required={"title", "count", "quantity_id"},
 *              description="demandItem",
 *              @SWG\Property(property="title", type="string"),
 *              @SWG\Property(property="count", type="number"),
 *              @SWG\Property(property="quantity_id", type="integer"),
 *          )
 *      ),
 *  )
 * Class CreateDemandRequest
 * @package App\Http\Requests
 */
class CreateDemandRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'string',
            'address' => 'string',
            'desc' => 'string',
            'delivery_date' => 'date',
            'addition_emails' => 'array',
            'addition_emails.*' => 'email',
            'regions' => 'array',
            'regions.*' => 'integer',
            'spheres' => 'array',
            'spheres.*' => 'integer',
            'demandItems' => 'array|required',
            'demandItems.*.title' => 'string|required',
            'demandItems.*.count' => 'numeric|required',
            'demandItems.*.quantity_id' => 'integer|required'
        ];
    }

    /**
     * @return Carbon
     */
    public function getDeliveryDate()
    {
        if (!isset($this->delivery_date)) {
            return null;
        }
        return Carbon::parse($this->delivery_date);
    }
}

