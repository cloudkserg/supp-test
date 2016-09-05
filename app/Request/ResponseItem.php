<?php

namespace App\Request;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ResponseItem
 * @package App\Request
 *
 * @property int $id
 * @property int $response_id
 * @property int $request_id
 * @property int $price_raw
 * @property float $price
 *
 * @property Response $response
 * @property Request $request
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
    public function request()
    {
        return $this->belongsTo(\Request::class);
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
