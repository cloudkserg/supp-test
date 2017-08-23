<?php

namespace App;

use App\Demand\Response;
use App\Services\UserService;
use App\Type\Region;
use App\Type\Sphere;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Company
 * @package App
 * @property int $id
 * @property string $title
 * @property string $founded
 * @property string $site
 * @property string $address
 * @property string $desc
 * @property string $email
 *
 * @property Sphere[] $spheres
 * @property Region[] $regions
 * @property \Illuminate\Database\Eloquent\Collection $users
 * @property Response[] $responses
 */
class Company extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'desc', 'address', 'site', 'founded', 'email'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }





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


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    /**
     * @return User
     */
    public function getAdmin()
    {
        return $this->users->first(
            function (User $user) {
                return $user->confirmed;
            },
            (new UserService())->getStubUser()
        );
    }
}
