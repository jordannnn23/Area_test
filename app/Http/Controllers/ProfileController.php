<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    //
    public function send_infos()
    {
        // $finduser = User::where('email', Auth::user()->email)->first();
        // dd(Auth::user()->name);
        dd(Auth::user());
        $data = [
            'nom' => Auth::user()->name,
            'email' => Auth::user()->email
        ];
        return response()->json($data);
    }
}
