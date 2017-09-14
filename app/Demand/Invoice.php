<?php

namespace App\Demand;

use App\Company;
use App\Type\InvoiceStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
/**
 * Class Invoice
 * @package App\Request
 *
 * @property int $id
 * @property string $status
 * @property int $response_id
 * @property string $filename
 * @property string $filepath
 *
 * @property \Illuminate\Database\Eloquent\Collection|ResponseItem[] $responseItems
 * @property Response $response
 */
class Invoice extends Model
{

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
    public function response()
    {
        return $this->belongsTo(Response::class);
    }


    public function getPath()
    {
        $path = storage_path('app/invoices/' . $this->response->company_id);
        if (!file_exists($path)) {
            $oldmask = umask(0);
            mkdir($path, '0777', true);
            umask($oldmask);
        }
        return $path;
    }


    public function getFilepathAttribute()
    {
        return $this->getPath() . '/' . $this->filename;
    }

    /**
     * @return bool
     */
    public function isResponsed()
    {
        return $this->status == InvoiceStatus::RESPONSED;
    }

    /**
     * @return bool
     */
    public function isRequested()
    {
        return $this->status == InvoiceStatus::REQUESTED;
    }
}
