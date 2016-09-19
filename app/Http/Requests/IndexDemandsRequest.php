<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 18.09.16
 * Time: 12:50
 */

namespace App\Http\Requests;


class IndexDemandsRequest extends ApiRequest
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
        if (is_array($this->get('status', null))) {
            return [
                'status' => 'array',
                'status.*' => 'string'
            ];
        }

        return [
            'status' => 'string'
        ];
    }


}