<?php

namespace App\Demand;

use App\Company;
use App\Type\DeliveryType;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Response
 * @package App\Demand
 *
 * @property int $id
 * @property int $company_id
 * @property int $demand_id
 * @property string delivery_type
 * @property string $status
 * @property \Carbon\Carbon readed_time
 * @property string $number
 * @property string $desc
 * @property \Carbon\Carbon updated_at
 *
 * @property Company $company
 * @property Demand $demand
 * @property \Illuminate\Database\Eloquent\Collection; $responseItems
 * @property Invoice[] $invoices
 *
 */
class Response extends Model
{
    protected $dates = [
        'readed_time'
    ];

    protected $fillable = [
        'delivery_type', 'status', 'desc', 'number'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function demand()
    {
        return $this->belongsTo(Demand::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function responseItems()
    {
        return $this->hasMany(ResponseItem::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
