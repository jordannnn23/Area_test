<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    //
    public function index()
    {
        $finduser = User::where('email', Auth::user()->email)->first();
        // dd(Auth::user()->name);
        // dd(Auth::user());
        $data = [
            'nom' => $finduser->name,
            'email' => $finduser->email
        ];
        return response()->json($data);
    }
}
