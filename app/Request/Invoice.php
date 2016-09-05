<?php

namespace App\Request;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Invoice
 * @package App\Request
 *
 * @property int $id
 * @property string $status
 * @property int $response_item_id
 *
 * @property ResponseItem $responseItem
 */
class Invoice extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function responseItem()
    {
        return $this->belongsTo(ResponseItem::class);
    }
}
