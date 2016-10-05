<?php

namespace App\Demand;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ResponseItem
 * @package App\Request
 *
 * @property int $id
 * @property int $response_id
 * @property int $demand_item_id
 * @property int $invoice_id
 * @property int $price_raw
 * @property float $price
 *
 * @property Response $response
 * @property Invoice $invoice
 * @property DemandItem $demandItem
 *
 */
class ResponseItem extends Model
{

    protected $fillable = [
        'price'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function response()
    {
        return $this->belongsTo(Response::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function demandItem()
    {
        return $this->belongsTo(DemandItem::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }


    /**
     * @param $value
     */
    public function setPriceAttribute($value)
    {
        $this->price_raw = $value*100;
    }

    /**
     * @return float
     */
    public function getPriceAttribute()
    {
        return $this->formatPrice($this->price_raw);
    }

    /**
     * @param $priceRaw
     * @return float
     */
    private function formatPrice($priceRaw)
    {
        return $priceRaw/100;
    }

    /**
     * @return float|null
     */
    public function getOriginalPrice()
    {
        $price_raw = $this->getOriginal('price_raw');
        if (!isset($price_raw)) {
            return null;
        }
        return $this->formatPrice($price_raw);
    }

    /**
     * @return bool
     */
    public function isDirtyPrice()
    {
        return $this->isDirty('price_raw');
    }

    /**
     * @return float
     */
    public function getTotalPrice()
    {
        return round($this->getPriceAttribute() * $this->demandItem->count, 2);
    }
}
