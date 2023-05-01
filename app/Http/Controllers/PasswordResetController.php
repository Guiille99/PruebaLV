<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function create(){
        return view('auth.forgot-password');
    }

    public function store(Request $request){
        // dd(Str::random(64));
        $request->validate([
            "email"=>'required|email|exists:users,email'
        ]);

        $status = Password::sendResetLink( //Comprobamos si el email corresponde a un usuario y guardamos la respuesta en la variable status
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm($token){
        return view("auth.reset-password", ['token'=>$token]);
    }

    public function reset(Request $request){
        $request->validate([
            "token"=>"required",
            "email"=>'required|email|exists:users,email',
            "password"=>"required|min:5|confirmed",
        ]);
        
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
     
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);

    }
}
