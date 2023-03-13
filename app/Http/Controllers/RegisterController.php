<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view("auth.register");
    }

    public function store(Request $request){
        $request->validate([ //Validación de campos
            "nombre" => "required|min:2|max:80|",
            "apellidos" => "required|min:2|max:80|",
            "email" => "required|unique:users",
            "username" => "required|min:5|max:25|unique:users",
            "password" => "required|min:5|max:80"
        ]);

        // En caso de que todos los datos se hayan enviado correctamente ingresaremos el usuario a la BD
        $user = new User();
        $user->username = $request->username;
        $user->password = Hash::make($request->password); //Encriptamos la contraseña
        $user->nombre = $request->nombre;
        $user->apellidos = $request->apellidos;
        $user->email = $request->email;

        $user->save(); //Guardamos al usuario en la BD
        Auth::login($user);
        // $request->session()->regenerate(); //Crea la sesión y la regeneramos para evitar problemas de seguridad
        return redirect()->route('index');  //Reenviamos al usuairo a la página principal ya registrado y con la sesión iniciada

    }
}
