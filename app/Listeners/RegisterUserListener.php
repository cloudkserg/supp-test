<?php

namespace App\Listeners;

use App\Events\RegisterUserEvent;
use App\Mail\RegisterUser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisterUserListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  RegisterUserEvent  $event
     * @return void
     */
    public function handle(RegisterUserEvent $event)
    {
        $user = $event->getUser();
        \Mail::to($user->email)->send(new RegisterUser($user));
    }
}
