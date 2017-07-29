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
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ResponseQuery extends DemandQuery  implements Query
{

    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;


    public function __construct()
    {
        $this->builder = Response::query();
    }


    /**
     * @param int $companyId
     * @return DemandQuery
     */
    public function forCompany($companyId)
    {
        $this->builder->whereCompanyId($companyId);
        return $this;
    }

    public function afterUpdatedAt(Carbon $time)
    {
        $this->builder->where(function (Builder $query) use ($time) {
            $query->where('updated_at', '>', $time)
                ->orWhere('created_at', '>', $time)
                ->orWhereHas('responseItems', function (Builder $query) use ($time) {
                    $query->where('updated_at', '>', $time)
                        ->orWhere('created_at', '>', $time)
                        ->orWhereHas('invoice', function (Builder $query) use ($time) {
                            $query->where('updated_at', '>', $time)
                                ->orWhere('created_at', '>', $time);
                        });
                })
                ->orWhereHas('demand', function (Builder $query) use ($time) {
                    $query->where('updated_at', '>', $time)
                        ->orWhere('created_at', '>', $time)
                        ->orWhereHas('demandItems', function (Builder $query) use ($time) {
                            $query->where('updated_at', '>', $time)
                                ->orWhere('created_at', '>', $time);
                        });
                });
        });
        return $this;
    }


    /**
     * @return Builder
     */
    public function getBuilder()
    {
        return $this->builder;
    }


}