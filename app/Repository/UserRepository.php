<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 10.07.17
 * Time: 12:40
 */

namespace App\Repository;


use App\User;

class UserRepository
{


    /**
     * @param $confirmationCode
     * @return User
     */
    public function findByConfirmationCode($confirmationCode)
    {
        return User::query()
            ->whereConfirmationCode($confirmationCode)
            ->whereConfirmed(false)
            ->first();
    }

}