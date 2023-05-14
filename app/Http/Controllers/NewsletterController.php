<?php

namespace App\Http\Controllers;

use App\Mail\NewsletterSuscribe;
use App\Models\EmailNewsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller{
    public function suscribeNewstler(Request $request){
        $request->validate([
            "email" => "required|email|unique:emails_newsletter"
        ]);
        DB::beginTransaction();
        try {
            $email = new EmailNewsletter();
            $email->email = $request->email;
            $email->save();
            DB::commit();
            // Mail::to($request->email)->send(new NewsletterSuscribe);
            MailController::sendEmailSuscribeNewstler($request);
            return redirect()->back()->with("message", "Tu suscripción a nuestro noticiero ha sido completada");
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
        }
    }
}
