<?php

namespace App\Http\Controllers;

// use App\Mail\EnviarCorreo;
use App\Mail\NewsletterSuscribe;
use App\Mail\NewsletterUnsuscribeWarning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;

class MailController extends Controller{
    public static function sendEmailSuscribeNewstler(Request $request){
        Mail::to($request->email)->queue(new NewsletterSuscribe);
    }

    public static function sendEmailUnsuscribeWarning($email){
        Mail::to($email)->queue(new NewsletterUnsuscribeWarning($email));
    }
}
