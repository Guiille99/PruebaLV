<?php

namespace App\Http\Controllers;

use App\Jobs\SendContactEmail;
use Illuminate\Http\Request;
use App\Models\Libro;

class ContactoController extends Controller
{
    public function index(){
        return view("contacto");
    }

    public function sendMessage(Request $request){
        $request->validate([
            "nombre" => "required",
            "email" => "required|email",
            "mensaje" => "required"
        ]);
        dispatch(new SendContactEmail($request->mensaje, $request->email));
        return redirect()->back();
    }
}
