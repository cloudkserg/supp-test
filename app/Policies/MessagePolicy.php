<?php

namespace App\Policies;

use App\Message;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    public function readed(User $user, Message $message)
    {
        return $user->company_id == $message->to_company_id;
    }


}
