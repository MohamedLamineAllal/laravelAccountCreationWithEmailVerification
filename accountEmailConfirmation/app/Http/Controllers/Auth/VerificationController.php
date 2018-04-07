<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use  App\Http\Controllers\Controller;

use App\{User, VerificationToken};

use Auth;

use App\Events\UserRequestedVerificationEmail;


class VerificationController extends Controller
{
    public function verify(VerificationToken $token) {
        $token->user()->update([
            'verified' => true
        ]);
        $token->delete();

        // Uncomment the following lines if you want to login the user 
        // directly upon email verification
        // Auth::login($token->user);
        // return redirect('/home');
    
        return redirect('/login')->withInfo('Email verification succesful. Please login again');
    }

    public function resend(Request $request) {
        $user = User::where('email', $request->email)->firstOrFail();

        if($user->hasVerifiedEmail()) {
            return redirect('/home')->withInfo('Your email has already been verified');
        }

        // if not already verified
        event(new UserRequestedVerificationEmail($user)); // emit the event
        
        return redirect('/login')->withInfo('Verification email resent. Please check your inbox');
    }

}