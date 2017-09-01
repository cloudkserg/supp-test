<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 18.09.16
 * Time: 12:50
 */

namespace App\Http\Requests;

use App\Message;
use App\Type\MessageStatus;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class IndexMessagesRequest extends ApiRequest
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
            'demandId' => 'integer',
            'status' => 'string'
        ];
    }



    public function getStatus()
    {
        $status = $this->get('status');
        if (!empty($status)) {
            return $status;
        }
        return MessageStatus::ACTIVE;
    }



}