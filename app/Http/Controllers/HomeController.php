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
}
