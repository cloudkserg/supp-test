<?php

namespace App\Policies;

use App\Demand\DemandItem;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DemandItemPolicy
{
    use HandlesAuthorization;

    public function update(User $user, DemandItem $demandItem)
    {
        return $user->company_id == $demandItem->demand->company_id;
    }

}
