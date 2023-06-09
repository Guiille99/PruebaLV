<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function index(){
        return view("auth.login");
    }

    public function store(Request $request){
        $remember = $request->filled('remember');

        $request->validate([ //Validación de campos
            "username" => "required",
            "password" => "required"
        ]);
        
        if (Auth::attempt($request->only('username', 'password', 'rol'), $remember)) { //Si se loguea correctamente
            $request->session()->regenerate(); //Me crea la sesión y la regeneramos para evitar problemas de seguridad
            $user = User::where('username', $request->username)->first(); //Obtenemos el usuario que ha iniciado sesión

            if ($user->rol=="Administrador") { //Si el usuario es un admin lo redirigimos a la página de admins
                return redirect()->route('admin.index');
            }
            else{
                return redirect()->route('index'); 
            }          
        }
        else{ //Si hay algún error
            $user = User::where('username', $request->username)->first();
            if ($user==null) { //Si el usuario no existe en la BD
                return redirect()->route('login')->withErrors(["username"=>"El usuario no existe"]);
            }
            else{
                return redirect()->route('login')->withErrors(["password"=>"Contraseña incorrecta"]);
            }
        }
    }

    public function logout(Request $request){ //Función para cerrar sesión
        Auth::logout();        
        // Por seguridad, invalidamos la sesión del usuario y regeneramos el token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
