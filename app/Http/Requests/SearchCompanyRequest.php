<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 13.09.16
 * Time: 16:24
 */

namespace App\Http\Requests;


use Carbon\Carbon;

/**
 *
 * Class SearchCompanyRequest
 * @package App\Http\Requests
 */
class SearchCompanyRequest extends ApiRequest
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
            'regions' => 'array|required',
            'regions.0' => 'int|required',
            'reqions.*' => 'int',
            'spheres' => 'array|required',
            'spheres.0' => 'int|required',
            'spheres.*' => 'int'
        ];
    }

}

