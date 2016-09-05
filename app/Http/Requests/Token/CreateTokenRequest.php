<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 05.09.16
 * Time: 20:47
 */

namespace App\Http\Requests\Token;


use App\Http\Requests\ApiRequest;

class CreateTokenRequest extends ApiRequest
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
            'email' => 'required|max:255',
            'password' => 'required|max:255'
        ];
    }

}