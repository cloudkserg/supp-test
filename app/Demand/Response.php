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
 * @property \Carbon\Carbon updated_at
 *
 * @property Company $company
 * @property Demand $request
 * @property ResponseItem[] $responseItems
 * @property Invoice[] $invoices
 *
 */
class Response extends Model
{

    protected $fillable = [
        'delivery_type', 'status'
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
