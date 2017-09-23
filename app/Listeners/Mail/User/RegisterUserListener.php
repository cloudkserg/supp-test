<?php

namespace App\Listeners\Mail\User;

use App\Demand\ResponseItem;
use App\Events\RegisterUserEvent;
use App\Mail\RegisterUser;
use App\Mail\RegisterUserForAdmin;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisterUserListener implements ShouldQueue
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

        \Mail::to(config('mail.adminEmails'))->send(new RegisterUserForAdmin($user));

    }
}
