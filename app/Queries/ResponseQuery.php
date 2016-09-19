<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 15.09.16
 * Time: 20:37
 */

namespace App\Queries;


use App\Demand\Demand;
use App\Demand\Response;
use Illuminate\Database\Eloquent\Builder;

class ResponseQuery extends DemandQuery
{


    public function __construct()
    {
        $this->builder = Response::query();
    }




}