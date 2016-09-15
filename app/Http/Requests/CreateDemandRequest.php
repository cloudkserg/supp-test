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
            'regions' => 'array',
            'spheres' => 'array',
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
        return Carbon::createFromFormat('d.m.Y', $this->delivery_date);
    }
}

