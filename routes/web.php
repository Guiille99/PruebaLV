<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Mail\ContactanosMailable;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarCorreo;
use App\Models\Libro;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, "index"])->name("index"); //Página principal 
Route::get('libros/{filtro}', [LibroController::class, "filter"])->name("libros.filter"); //Página para mostrar los libros filtrados por título, autor o género
Route::post('libros', [LibroController::class, "getFiltro"])->name("libros.getFiltro"); //Página para mostrar los libros filtrados por título, autor o género
Route::get('libro/{libro}', [LibroController::class, "show"])->name("libros.show"); //Página para mostrar un libro concreto

Route::get('admin', [UserController::class, "index"])->middleware('checkadmin')->name("admin.index"); //Página principal del admin
Route::delete('admin/{user}', [UserController::class, "destroy"])->middleware('checkadmin')->name("user.destroy"); //Página para eliminar un usuario
Route::get('admin/{user}/edit', [UserController::class, "edit"])->middleware('checkadmin')->name("user.edit"); //Página para mostrar el formulario de actualización de usuario
Route::put('admin/{user}/edit', [UserController::class, "update"])->middleware('checkadmin')->name("user.update"); //Página para actualizar el usuario
Route::get('admin/usuarios', [UserController::class, "index"])->middleware('checkadmin')->name("admin.users"); //Página que muestra los registros de los usuarios
Route::get('admin/user/create', [UserController::class, "create"])->middleware('checkadmin')->name("user.create");
Route::post('admin/user', [UserController::class, "store"])->middleware('checkadmin')->name("user.store");
Route::get('perfil/{user}', [UserController::class, "editPerfil"])->middleware('auth')->name("user.editPerfil"); //Página para mostrar el formulario de actualización de usuario desde la página principal
Route::put('perfil/{user}', [UserController::class, "updatePerfil"])->middleware('auth')->name("user.updatePerfil"); //Página para mostrar el formulario de actualización de usuario desde la página principal

Route::get('admin/libros', [LibroController::class, "index"])->middleware('checkadmin')->name("libros.index"); //Página para mostar todos los libros
Route::delete('admin/libros/{libro}', [LibroController::class, "destroy"])->middleware('checkadmin')->name("libro.destroy"); //Página para eliminar un usuario
Route::get('admin/libros/{libro}/edit', [LibroController::class, "edit"])->middleware('checkadmin')->name("libro.edit"); //Página para mostrar el formulario de actualización de usuario
Route::put('admin/libros/{libro}/edit', [LibroController::class, "update"])->middleware('checkadmin')->name("libro.update"); 
Route::get('admin/libros/create', [LibroController::class, "create"])->middleware('checkadmin')->name('libro.create');
Route::post('admin/libros', [LibroController::class, "store"])->middleware('checkadmin')->name("libro.store");

Route::get('blog', function(){
    $generos = LibroController::getGeneros();
    return view('blog', compact('generos'));
})->name('blog');

Route::get('/login', [LoginController::class, "index"])->name("login");
Route::post('/login', [LoginController::class, "store"])->name("login.store");
Route::put('/logout', [LoginController::class, "logout"])->name("login.logout");

Route::get('/register', [RegisterController::class, "index"])->name("register.index");
Route::post('/register', [RegisterController::class, "store"])->name("register.store");

Route::get('/contacto', [ContactoController::class, "index"])->name("contacto");


Route::post('enviar-correo', function() 
{
    Mail::to(request()->mail)->send(new EnviarCorreo);
    // return "Correo enviado exitosamente";
    $generos = LibroController::getGeneros();
    return view('mails.confirmacion-correo', compact('generos'));
})->name('enviar-correo');
