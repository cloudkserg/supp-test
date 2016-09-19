<?php

namespace App\Policies;

use App\Demand\Demand;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DemandPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Demand $demand)
    {
        return $user->company_id == $demand->company_id;
    }

}
