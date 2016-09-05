<?php

namespace App;

use App\Type\Region;
use App\Type\Sphere;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Company
 * @package App
 * @property int $id
 * @property string $title
 *
 * @property Sphere[] $spheres
 * @property Region[] $regions
 */
class Company extends Model
{






    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function spheres()
    {
        return $this->belongsToMany(Sphere::class, 'company_spheres');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function regions()
    {
        return $this->belongsToMany(Region::class, 'company_regions');
    }
}
