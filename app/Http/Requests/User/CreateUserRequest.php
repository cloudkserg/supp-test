<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ApiRequest;

/**
 * Class CreateUserRequest
 * @package App\Http\Requests
 *
 * @property string $company_title
 * @property string $name
 * @property string $email
 * @property string $password
 *
 */
class CreateUserRequest extends ApiRequest
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
            'company_title' => 'required|max:255|unique:companies,title',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ];
    }
}
