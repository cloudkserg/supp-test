<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 05.10.16
 * Time: 0:22
 */

use App\Mail\RegisterUser as RegisterUser;
use App\Events\RegisterUserEvent;
use \Illuminate\Foundation\Testing\DatabaseMigrations;


class RegisterUserListenerTest extends TestCase
{
    use DatabaseMigrations;

    public function testHandle()
    {
        $this->createBeforeCompany();
        factory(\App\Company::class)->create();
        $user = factory(\App\User::class)->create([
            'email' => 'test@example.com'
        ]);
        $event = new RegisterUserEvent($user);

        Mail::fake();
        $listener = new \App\Listeners\Mail\User\RegisterUserListener();
        $listener->handle($event);

        Mail::assertSent(RegisterUser::class, function ($mail) use ($user) {
           return $mail->user->id == $user->id;
        });
        Mail::assertSentTo([$user->email], RegisterUser::class);

    }


}