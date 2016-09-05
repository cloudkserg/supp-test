<?php

namespace App\Request;

use App\Company;
use App\Type\Region;
use App\Type\Sphere;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Class Request
 *
 * @property int $id
 * @property string $title
 * @property string $desc
 * @property string address
 * @property Carbon delivery_date
 * @property string[] addition_emails
 * @property string addition_emails_raw
 * @property int $company_id
 *
 * @property Company $company
 * @property Region[] $regions
 * @property Sphere[] $spheres
 *
 *
 * @package App\Request
 */
class Request extends Model
{
    protected $dates = [
        'delivery_date'
    ];

    protected $fillable = [
        'title', 'desc',
        'address', 'delivery_date',
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
        return $this->belongsToMany(Region::class, 'request_regions');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function spheres()
    {
        return $this->belongsToMany(Sphere::class, 'request_spheres');
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
    public function setAdditionEmailsAttributes(array $emails)
    {
        $this->addition_emails_raw = serialize($emails);
    }
}
