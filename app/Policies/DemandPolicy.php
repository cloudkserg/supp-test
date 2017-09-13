<?php

namespace App\Policies;

use App\Company;
use App\Demand\Demand;
use App\Demand\Response;
use App\Type\DemandStatus;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Collection;

class DemandPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Demand $demand)
    {
        return $demand->isOwner($user);
    }

    public function active(User $user, Demand $demand)
    {
        return (
            $demand->isOwner($user) and
            $demand->isDraft() and
            $demand->demandItems->isNotEmpty() and
            $demand->regions->isNotEmpty() and
            $demand->spheres->isNotEmpty()
        );
    }

    public function cancel(User $user, Demand $demand)
    {
        return (
            $demand->isOwner($user) and
            $demand->isCancelled()
        );
    }

    public function message(User $user, Demand $demand, $anotherCompanyId)
    {
        return  (
            (
                $this->isHisDemand($demand, $user->company_id) and $this->isCompanyInResponses($demand->responses, $anotherCompanyId)

            ) or (
                $this->isHisDemand($demand, $anotherCompanyId) and $this->isCompanyInResponses($demand->responses, $user->company_id)
            )
        );
    }


    private function isHisDemand(Demand $demand, $companyId)
    {
        return $demand->company_id == $companyId;
    }

    private function isCompanyInResponses(Collection $responses, $companyId)
    {
        return $responses
            ->filter(function (Response $response) use ($companyId) {
                return $response->company_id == $companyId;
            })
            ->isNotEmpty();
    }

}
