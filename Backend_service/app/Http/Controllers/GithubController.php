<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;


class GithubController extends Controller
{
    //
    public function loginWithGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function callbackFromGithub()
    {
        $githubUser = Socialite::driver('github')->user();
        
        //dd($githubUser);
        $finduser = User::where('github_id', $githubUser->id)->first();
        if ( $finduser ) {
            
            Auth::login($finduser);
            return redirect("http://localhost:3000/dashboard/profile");

            } else {
                $user = User::updateOrCreate([
                    'github_id' => $githubUser->id,
                    'name' => $githubUser->name,
                    'email' => $githubUser->email,
                    'password' => encrypt('dummypass')
                    // 'github_token' => $githubUser->token,
                    // 'github_refresh_token' => $githubUser->refreshToken,
                    ]);

                Auth::login($user);

                return redirect("http://localhost:3000/dashboard/profile");
            }
    }
}
