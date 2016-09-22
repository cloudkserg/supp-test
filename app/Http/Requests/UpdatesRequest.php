<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 18.09.16
 * Time: 12:50
 */

namespace App\Http\Requests;

use App\Demand\Demand;
use App\Services\DemandService;
use Carbon\Carbon;

class UpdatesRequest extends ApiRequest
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
            'timestamp' => 'int',
        ];
    }

    /**
     * @return Carbon
     */
    public function getTime()
    {
        if (!isset($this->timestamp)) {
            return Carbon::createFromTimestamp(null);
        }
        return Carbon::createFromTimestamp($this->timestamp);
    }


}