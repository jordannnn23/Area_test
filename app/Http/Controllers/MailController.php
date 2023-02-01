<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\MailNotify;
use Illuminate\Support\Facades\Mail;
use Exception;

class MailController extends Controller
{
    public function index()
    {
        $data = [
            'subject' => 'Area Mail',
            'body' => 'La pignouf',
            'mail' => 'akohajordan@gmail.com'
        ];
        try {
            Mail::to('akohajordan@gmail.com')
                ->send(new MailNotify($data));
            return response()->json(['Bien']);
        } catch (Exception $th) {
            return response()->json(['Erreur']);
        }
    }
}
