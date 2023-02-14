<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    //
    public function index($email)
    {
        $finduser = User::where('email', $email)->first();
        // dd(Auth::user()->name);
        // dd(Auth::user());
        $data = [
            'nom' => $finduser->name,
            'email' => $finduser->email
        ];
        return response()->json($data);
    }
}
