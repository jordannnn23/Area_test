<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Exception;

class GoogleController extends Controller
{
    public function loginWithGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackFromGoogle()
    {
        try {
            
            //dd("ok2");
            $user = Socialite::driver('google')->user();
            //dd($user);
            $finduser = User::where('google_id', $user->id)->first();
            //dd("ok3");
            if ( $finduser ) {
                
                Auth::login($finduser);
                return redirect("http://localhost:3000/dashboard/profile");
                
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'google_token'=> $user->token,
                    'google_refresh_token'=> $user->refreshToken,
                    'password' => encrypt('dummypass')
                ]);
      
                Auth::login($newUser);
                return redirect("http://localhost:3000/dashboard/profile");
            }
      
        } catch (Exception $e) {
            dd($e->getMessage());
            abort(500);
        }
    }   
}