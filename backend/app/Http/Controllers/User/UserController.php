<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SubmitEmailRequest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendAuthentificationMail;

class UserController extends Controller
{
    public function submit(SubmitEmailRequest $request): object
    {

        $user = User::firstOrCreate([
            'email' => $request->email
        ]);
       // return response()->json(['message' => "{$user->phone}"]);
        if (!$user){
            return response()->json(['message'=> 'Could not process a user'], 401);
        }

        $token = rand(111111, 999999);

        $user->update([
            'login_code' => $token
        ]);

        $mailData = [
            'title' => "Your authorisation token",
            'body' => "Your token is {$token} Don't share it with someone"
        ];

        Mail::to($user->email)->send(new SendAuthentificationMail($mailData));
        // $user->notify(new LoginNeedsVerification());
        
        return response()->json(['message' => "Notification sent"]);

    }    
}
