<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libro;
use App\Models\User;

class HomeController extends Controller
{
    public function index(){

        $libros_recomendados = Libro::orderby('valoracion', 'desc')->take(5)->get();
        $libros_recientes = Libro::orderby('fecha_publicacion', 'desc')->take(5)->get();
        return view("index", compact('libros_recomendados', 'libros_recientes'));
    }

    public function showQuienesSomos(){
        return view('empresa.quienes-somos');
    }

    public function showCondicionesUso(){
        return view('empresa.condiciones-uso');
    }
    public function showProteccionDatos(){
        return view('empresa.politica-proteccion-datos');
    }
    public function showPoliticaCookies(){
        return view('empresa.politica-cookies');
    }
    public function showHelp(){
        return view('empresa.support');
    }
}
