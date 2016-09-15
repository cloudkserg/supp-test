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
 * @property int delivery_type_id
 * @property string $status
 *
 * @property Company $company
 * @property Demand $request
 * @property DeliveryType $deliveryType
 * @property ResponseItem[] $responseItems
 *
 */
class Response extends Model
{
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deliveryType()
    {
        return $this->belongsTo(DeliveryType::class);
    }
}
