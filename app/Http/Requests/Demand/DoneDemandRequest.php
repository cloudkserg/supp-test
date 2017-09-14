<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 05.09.17
 * Time: 20:25
 */

namespace App\Http\Requests\Demand;


class DoneDemandRequest extends StatusDemandRequest
{
    public function authorize()
    {
        return $this->user()->can('done', $this->getDemand());
    }


}