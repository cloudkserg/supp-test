<?php

namespace App\Request;

use App\Company;
use App\Type\DeliveryType;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Response
 * @package App\Request
 *
 * @property int $id
 * @property int $company_id
 * @property int $request_id
 * @property int delivery_type_id
 * @property string $status
 *
 * @property Company $company
 * @property Request $request
 * @property DeliveryType $deliveryType
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
    public function request()
    {
        return $this->belongsTo(\Request::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deliveryType()
    {
        return $this->belongsTo(DeliveryType::class);
    }
}
