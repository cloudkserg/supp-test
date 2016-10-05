<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 13:13
 */

namespace App\Events;
use App\User;

class RegisterUserEvent
{
    /**
     * @var User
     */
    private $_user;


    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->_user = $user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->_user;
    }



}