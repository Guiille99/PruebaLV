<?php

namespace App\Http\Controllers;

// use App\Mail\EnviarCorreo;
use App\Mail\NewsletterSuscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller{
    public static function sendEmailSuscribeNewstler(Request $request){
        Mail::to($request->email)->send(new NewsletterSuscribe);
    }
}
