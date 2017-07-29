<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 15.09.16
 * Time: 20:37
 */

namespace App\Queries;


use App\Message;
use Illuminate\Database\Eloquent\Builder;

class MessageQuery  implements Query
{

    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;

    public function __construct()
    {
        $this->builder = Message::query();
    }

    /**
     * @param int $companyId
     * @return $this
     */
    public function forCompany($companyId)
    {
        $this->builder->where(function (Builder $query) use ($companyId) {
            $query->where('from_company_id', $companyId)
                ->orWhere('to_company_id', $companyId);
        });
        return $this;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function forStatus($status)
    {
        $this->builder->whereStatus($status);
        return $this;
    }

    /**
     * @param int $demandId
     * @return $this
     */
    public function forDemand($demandId)
    {
        $this->builder->whereDemandId($demandId);
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