<?php

namespace App\Request;

use App\Type\Quantity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RequestItem
 * @package App\Request
 *
 * @property int $id
 * @property string $title
 * @property float $count
 * @property int $quantity_id
 * @property int $request_id
 * @property string $status
 *
 * @property Quantity $quantity
 * @property Request $request
 */
class RequestItem extends Model
{

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
    public function request()
    {
        return $this->belongsTo(\Request::class);
    }


}
