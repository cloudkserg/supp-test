<?php

namespace App\Policies;

use App\Demand\Demand;
use App\Demand\Response;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DemandPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Demand $demand)
    {
        return $user->company_id == $demand->company_id;
    }


    public function message(User $user, Demand $demand)
    {
        return (
            $user->company_id == $demand->company_id or
            collect($demand->responses)
                ->filter(function (Response $response) use ($user) {
                    return $response->company_id == $user->company_id;
                })
                ->isNotEmpty()
        );
    }

}
