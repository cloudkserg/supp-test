<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ApiRequest;
use Swagger\Annotations as SWG;


/**
 * @SWG\Definition(
 *      definition="CreateUserRequest",
 *      required={"companyTitle", "name", "email", "password"},
 *      @SWG\Property(property="companyTitle", type="string", maxLength=255, description="title unique for company"),
 *      @SWG\Property(property="name", type="string", maxLength=255, description="user name"),
 *      @SWG\Property(property="email", type="string", description="email unique for users" ),
 *      @SWG\Property(property="password", type="string", minLength=6, description="password, check for confirm"),
 *      @SWG\Property(property="passwordConfirmation", type="string", minLength=6, description="confirmation with pass"),
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
 * )
 *
 *
 *
 * Class CreateUserRequest
 * @package App\Http\Requests
 *
 * @property string $company_title
 * @property string $name
 * @property string $email
 * @property string $password
 * @property int[] $spheres
 * @property int[] $regions
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
            'companyTitle' => 'required|max:255|unique:companies,title',

            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|same:passwordConfirmation',

            'regions' => 'array|required',
            'regions.*' => 'integer',
            'spheres' => 'array|required',
            'spheres.*' => 'integer',
        ];
    }
}
