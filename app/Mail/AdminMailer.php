<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 23.09.17
 * Time: 14:26
 */

namespace App\Mail;


use Illuminate\Contracts\Mail\Mailable;

class AdminMailer
{

    public function sendMails(Mailable $mail)
    {
        $adminEmails = config('mail.adminEmails');
        foreach ($adminEmails as $adminEmail) {
            \Mail::to($adminEmail)->send($mail);
        }
    }

}