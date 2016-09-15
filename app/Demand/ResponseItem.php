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
 * @property int $price_raw
 * @property float $price
 *
 * @property Response $response
 * @property DemandItem $demandItem
 *
 */
class ResponseItem extends Model
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function response()
    {
        return $this->belongsTo(\Response::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function demandItem()
    {
        return $this->belongsTo(DemandItem::class);
    }


    /**
     * @param $value
     */
    public function setPrice($value)
    {
        $this->price_raw = $value*100;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price_raw/100;
    }
}
