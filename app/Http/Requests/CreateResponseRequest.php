<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 13.09.16
 * Time: 16:24
 */

namespace App\Http\Requests;


use App\Http\Requests\ApiRequest;

class CreateResponseRequest extends ApiRequest
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
            'delivery_type' => 'string',
            'demand_id' => 'integer|required',
            'responseItems' => 'array|required',
            'responseItems.*.demand_item_id' => 'integer|required',
            'responseItems.*.price' => 'numeric|required'
        ];
    }

}

