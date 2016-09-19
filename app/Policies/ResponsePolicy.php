<?php

namespace App\Policies;

use App\Demand\Response;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResponsePolicy
{
    use HandlesAuthorization;

    public function update(User $user, Response $response)
    {
        return $user->company_id == $response->company_id;
    }

}
