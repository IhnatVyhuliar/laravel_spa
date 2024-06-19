<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SubmitEmailRequest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendAuthentificationMail;
use App\Http\Requests\AuthoriseLoginCodeRequest;

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

    public function authorise(AuthoriseLoginCodeRequest $request)
    {
        $user = User::whereRaw("email", $request->email)
            ->where('login_code', $request->login_code)
            ->first();
        // return  $request->email;
        if ($user)
        {
            $user->update([
                'login_code' => null
            ]);
        
            $token = $user->createToken($request->login_code)->plainTextToken;
            return response()->json(['message'=> "Successfully authorised", 'token'=> $token]); 
        }

        return response()->json(['message'=> "Invalid verification code"], 401);
    }
    //2|ztXQPFH5KuHS3VX1szN5yuT8rgYCUdwdi3BddUKRf557502d

}
