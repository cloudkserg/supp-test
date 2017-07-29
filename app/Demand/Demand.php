<?php

namespace App\Demand;

use App\Collections\DemandCollection;
use App\Company;
use App\Type\DemandStatus;
use App\Type\Region;
use App\Type\ResponseStatus;
use App\Type\Sphere;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Class Demand
 *
 * @property int $id
 * @property string $title
 * @property string $number
 * @property string $desc
 * @property string address
 * @property Carbon delivery_date
 * @property string[] addition_emails
 * @property string addition_emails_raw
 * @property int $company_id
 * @property string $status
 * @property \Carbon\Carbon updated_at
 *
 * @property Company $company
 * @property Region[] $regions
 * @property Sphere[] $spheres
 * @property DemandItem[] $demandItems
 * @property \Illuminate\Database\Eloquent\Collection|Response[] $responses
 *
 *
 * @package App\Demand
 */
class Demand extends Model
{

    protected $dates = [
        'delivery_date'
    ];

    protected $fillable = [
        'title', 'desc', 'number',
        'address',
        'addition_emails'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function regions()
    {
        return $this->belongsToMany(Region::class, 'demand_regions');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function spheres()
    {
        return $this->belongsToMany(Sphere::class, 'demand_spheres');
    }
    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function activeResponses()
    {
        return $this->hasMany(Response::class)->whereIn('responses.status', [
            ResponseStatus::ACTIVE,
            ResponseStatus::ARCHIVED
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function responses()
    {
        return $this->hasMany(Response::class);
    }



    /**
     * @param $value
     * @return mixed
     */
    public function getAdditionEmailsAttribute($value)
    {
        return unserialize($this->addition_emails_raw);
    }

    /**
     * @param array $emails
     */
    public function setAdditionEmailsAttribute(array $emails)
    {
        $this->addition_emails_raw = serialize($emails);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function demandItems()
    {
        return $this->hasMany(DemandItem::class);
    }


    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->status == DemandStatus::ACTIVE;
    }





}