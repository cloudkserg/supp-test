<?php

namespace App\Demand;

use App\Type\Quantity;
use App\Type\ResponseItemStatus;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RequestItem
 * @package App\Demand
 *
 * @property int $id
 * @property string $title
 * @property float $count
 * @property int $quantity_id
 * @property int $demand_id
 * @property int|null $response_item_id
 *
 * @property Quantity $quantity
 * @property Demand $demand
 * @property ResponseItem[] $responseItems
 * @property ResponseItem $selectedResponseItem
 */
class DemandItem extends Model
{

    protected $fillable = [
        'title', 'count',
        'quantity_id'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function selectedResponseItem()
    {
        return $this->belongsTo(ResponseItem::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quantity()
    {
        return $this->belongsTo(Quantity::class);
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

}
