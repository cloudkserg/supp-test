<?php

namespace App\Policies;

use App\Demand\ResponseItem;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResponseItemPolicy
{
    use HandlesAuthorization;

    public function update(User $user, ResponseItem $responseItem)
    {
        return $user->company_id == $responseItem->response->company_id and $responseItem->response->demand->isActive();
    }

}
