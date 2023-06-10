<?php

namespace App\Http\Controllers;

use App\Jobs\SendNewsletterSuscribe;
use App\Jobs\SendNewsletterUnsuscribeWarning;
use App\Models\EmailNewsletter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            dispatch(new SendNewsletterSuscribe($request->email));
            return redirect()->back()->with("message", "Tu suscripción a nuestro noticiero ha sido completada");
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
        }
    }

    public function destroyNewsletterView(User $user){
        $isNewsletterRegister = EmailNewsletter::where('email', $user->email)->exists();
        return view('users.editPerfil-deleteNewsletter', compact('user', 'isNewsletterRegister'));
    }

    public function destroyNewsletterNoAccountView(){
        return view('newsletter.unsuscribe');
    }

    public function unsuscribe(Request $request){
        if (Hash::check($request->password, Auth::user()->password)) {
            DB::beginTransaction();
            try {
                EmailNewsletter::where('email', Auth::user()->email)->delete();
                DB::commit();
                return redirect()->back()->with("message", "Se ha dado de baja del Newsletter correctamente");
            } catch (\Throwable $e) {
                DB::rollBack();
                return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
            }
        }
        else{
            return redirect()->back()->withErrors(["password"=>"Contraseña incorrecta"]);
        }
    }

    public function unsuscribeNoAccount($token, $email){
        if (EmailNewsletter::where('email', $email)->exists()) { //Si el email existe en la BD
            DB::beginTransaction();
            try {
                EmailNewsletter::where('email', $email)->delete();
                DB::commit();
                return redirect()->route('newsletter.destroy-no-account-view')->with('message_success', 'Se ha dado de baja correctamente');
            } catch (\Throwable $e) {
                DB::rollBack();
                return redirect()->route('newsletter.destroy-no-account-view')->with('message_success', 'Ha ocurrido un error inesperado');
            }
        }
        else{
            return redirect()->route('newsletter.destroy-no-account-view')->with('message_error', 'Este email no está suscrito al Newsletter'); 
        }
    }

    public function unsuscribeEmail(Request $request){
        $request->validate([
            "email" => "required|email|exists:emails_newsletter,email"
        ]);
        dispatch(new SendNewsletterUnsuscribeWarning($request->email));
        return redirect()->back()->with("message", "Se ha enviado un email a su correo electrónico");
    }
}
