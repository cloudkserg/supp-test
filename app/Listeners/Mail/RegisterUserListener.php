<?php

namespace App\Listeners\Mail;

use App\Events\RegisterUser;
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
     * @param  RegisterUser  $event
     * @return void
     */
    public function handle(RegisterUser $event)
    {
        $user = $event->getUser();
        \Mail::send('auth.emails.confirmation', [$user], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Регистрация на сайте ' . env('APP_NAME'));
        });
    }
}
