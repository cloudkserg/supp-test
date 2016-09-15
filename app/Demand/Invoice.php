<?php

namespace App\Demand;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Invoice
 * @package App\Request
 *
 * @property int $id
 * @property string $status
 * @property int $response_item_id
 * @property string $file
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


    public function getFile()
    {
        return 'string';
    }
}
