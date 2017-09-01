<?php

namespace App\Policies;

use App\Demand\Demand;
use App\Demand\Response;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Collection;

class DemandPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Demand $demand)
    {
        return $user->company_id == $demand->company_id;
    }


    public function message(User $user, Demand $demand)
    {
        return  (
            $user->company_id == $demand->company_id or
            $this->companyInResponses($demand->responses, $user->company_id)
        );
    }


    private function companyInResponses(Collection $responses, $companyId)
    {
        return $responses
            ->filter(function (Response $response) use ($companyId) {
                return $response->company_id == $companyId;
            })
            ->isNotEmpty();
    }

}
