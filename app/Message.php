<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 29.07.17
 * Time: 16:37
 */

namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Demand\Demand;
/**
 * Class Message
 * @package App
 *
 * @property int $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon readed_time
 * @property string $status
 * @property int $to_company_id
 * @property int $from_company_id
 * @property int $demand_id
 * @property string $text
 *
 * @property Company $toCompany
 * @property Company $fromCompany
 * @property Demand $demand
 *
 *
 */
class Message  extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text',
        'status',
        'readed_time',
        'from_company_id',
        'to_company_id',
        'demand_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function toCompany()
    {
        return $this->belongsTo(Company::class, 'to_company_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fromCompany()
    {
        return $this->belongsTo(Company::class, 'from_company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function demand()
    {
        return $this->belongsTo(Company::class, 'demand_id');
    }


}