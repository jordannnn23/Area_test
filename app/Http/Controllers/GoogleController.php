<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Exception;
use App\Mail\MailNotify;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class GoogleController extends Controller
{

    public function createe() {
        return view('auth.register');
    }

    public function createepost(Request $request) {
        $data = ([
            'subject' => 'Notification',
            'body' => 'new notif '
        ]);
        $this->send_mail($data);
        dd($request);
    }

    public function loginWithGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function send_mail($data) {
        try {
            Mail::to(Auth::user()->email)
                ->send(new MailNotify($data));
            return response()->json([
                'status' => '200',
                'message' => 'User create with success !'
            ]);
        } catch (Exception $th) {
            return response()->json([
                'status' => '201',
                'message' => 'Error while sending the mail. Check your Email adress !'
            ]);
        }
    }

    public function callbackFromGoogle(Request $request)
    {
        try {
            
            //dd("ok2");
            $user = Socialite::driver('google')->user();
            //dd($user);
            $finduser = User::where('google_id', $user->id)->first();

            //dd("ok3");
            // if ( $finduser ) {
            //     $finduser->google_token = $user->google_token;
            //     $finduser->google_refresh_token = $user->google_refresh_token;
            //     $finduser->save();
            //     Auth::login($finduser);
            //     return redirect("http://localhost:3000/dashboard/services");
            //dd("ok3");
            if ( $finduser ) {
                $email = $finduser->email;
                Auth::login($finduser);
                return redirect()->away("http://localhost:3000/dashboard/profile")->with('email');
                
            } else {
                $password = Str::random(8);
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'google_token'=> $user->token,
                    'google_refresh_token'=> $user->refreshToken,
                    'password' => Hash::make($password)
                ]);
                Auth::login($newUser);
                $data = ([
                    'subject' => 'Your password for area',
                    'body' => 'Thanks you for subscribe to Area.\n This is your password for area: '.$password
                ]);
                $this->send_mail($data);
                Auth::login($user);
                return redirect("http://localhost:3000/dashboard/services");
            }
      
        } catch (Exception $e) {
            dd($e->getMessage());
            abort(500);
        }
    }

    public function storeInfos(Request $request) {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required'],
            ]);
            $finduser = User::where('email', $request->email)->first();
            if ($finduser) {
                return response()->json([
                    "message"=>"Customer already exist!",
                    "status"=>201,
                ]);
            }
            else {
                $password = Str::random(8);
                $newUser = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'google_id'=> $request->id,
                    'password' => Hash::make($password)
                ]);
                $data = ([
                    'subject' => 'Your password for area',
                    'body' => 'Thanks you for subscribe to Area.\n This is your password for area: '.$password
                ]);
                $this->send_mail($data);
            }
            return response()->json([
                "message"=>"Customer add with success",
                "status"=>200,
            ]);
        } catch (Exception $e) {
            dd($e->getMessage());
            abort(500);
        }
    }
}