<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libro;

class ContactoController extends Controller
{
    public function index(){
        return view("contacto");
    }
}
