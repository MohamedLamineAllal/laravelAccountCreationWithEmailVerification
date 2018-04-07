<?php

namespace App\Listeners;

use App\Events\UserRequestedVerificationEmail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Mail;
use App\Mail\SendVerificationToken;
use App\VerifcationToken;


class SendVerificationEmail
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
     * @param  event 
     * @return void
     */
    public function handle($event)
    {   
        // try {
            Mail::to($event->user)->send(new SendVerificationToken($event->user->verificationToken));
        // } catch (Exception $e) {
        //     return redirect('/login')
        //         ->withError('An error occured and couldn\'t send the email. <a href="' . route('auth.verify.resend') . '?email=' . $event->user->email .'">Resend?</a>');
        // }
    }
}
