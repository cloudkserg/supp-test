<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 05.09.17
 * Time: 20:25
 */

namespace App\Http\Requests\Demand;


class CancelDemandRequest extends StatusDemandRequest
{
    public function authorize()
    {
        return $this->user()->can('cancel', $this->getDemand());
    }


}