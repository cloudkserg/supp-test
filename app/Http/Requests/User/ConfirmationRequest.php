<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 05.09.16
 * Time: 20:47
 */

namespace App\Http\Requests\User;


use App\Http\Requests\ApiRequest;
use App\Services\UserService;
use Swagger\Annotations as SWG;

/**
 * @SWG\Definition(
 *      definition="ConfirmationRequest",
 *      required={"confirmationCode"},
 *      @SWG\Property(property="confirmationCode", type="string", maxLength=255, description="code confirm from email")
 * )
 * Class ConfirmationRequest
 * @package App\Http\Requests\User
 */
class ConfirmationRequest extends ApiRequest
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
            'confirmationCode' => 'required|max:255'
        ];
    }


}