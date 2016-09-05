<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 18:16
 */

namespace App\Http\Requests;


class CreateRequest extends Request
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
            'desc' => 'string',
            'address' => 'string',
            'delivery_date' => 'date',
            'addition_emails' => 'array',
            'regions' => 'array',
            'spheres' => 'array'
        ];
    }
}