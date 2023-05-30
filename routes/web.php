<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\DireccionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProvinciaController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
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

Route::get('admin', [AdminController::class, "index"])->middleware('checkadmin')->name("admin.index"); //Página principal del admin
Route::delete('admin/{user}', [UserController::class, "destroy"])->middleware('checkadmin')->name("user.destroy"); //Página para eliminar un usuario
Route::get('admin/{user}/edit', [UserController::class, "edit"])->middleware('checkadmin')->name("user.edit"); //Página para mostrar el formulario de actualización de usuario
Route::put('admin/{user}/edit', [UserController::class, "update"])->middleware('checkadmin')->name("user.update"); //Página para actualizar el usuario
Route::get('admin/usuarios', [UserController::class, "show"])->middleware('checkadmin')->name("admin.users"); //Página que muestra los registros de los usuarios
Route::get('admin/user/create', [UserController::class, "create"])->middleware('checkadmin')->name("user.create");
Route::post('admin/user', [UserController::class, "store"])->middleware('checkadmin')->name("user.store");
Route::get('perfil/{user}', [UserController::class, "editPerfil"])->middleware('auth')->name("user.editPerfil"); //Página para mostrar la interfaz para editar el perfil
Route::get('perfil/my-data/{user}', [UserController::class, "myData"])->middleware('auth')->name("user.editPerfil-datos");
Route::delete('perfil/my-data/{user}', [UserController::class, "deleteImageProfile"])->middleware('auth')->name("user.deleteImageProfile");
Route::get('perfil/addresses/{user}', [UserController::class, "myAddresses"])->middleware('auth')->name("user.editPerfil-direcciones");
Route::get('perfil/account_password/{user}', [UserController::class, "myAccountPassword"])->middleware('auth')->name("user.editPerfil-password");
Route::get('perfil/delete_account/{user}', [UserController::class, "destroyAccountView"])->middleware('auth')->name("user.destroy-view");
Route::delete('perfil/delete_account/{user}', [UserController::class, "destroyAccountPerfil"])->middleware('auth')->name('user.destroy-perfil'); 
Route::put('perfil/{user}', [UserController::class, "updatePerfil"])->middleware('auth')->name("user.updatePerfil"); //Página para mostrar el formulario de actualización de usuario desde la página principal
Route::put('update-password', [UserController::class, "updatePassword"])->middleware('auth')->name("change.password");

Route::get('admin/libros', [LibroController::class, "index"])->middleware('checkadmin')->name("libros.index"); //Página para mostar todos los libros
Route::delete('admin/libros/{libro}', [LibroController::class, "destroy"])->middleware('checkadmin')->name("libro.destroy"); //Página para eliminar un usuario
Route::get('admin/libros/{libro}/edit', [LibroController::class, "edit"])->middleware('checkadmin')->name("libro.edit"); //Página para mostrar el formulario de actualización de usuario
Route::put('admin/libros/{libro}/edit', [LibroController::class, "update"])->middleware('checkadmin')->name("libro.update"); 
Route::get('admin/libros/create', [LibroController::class, "create"])->middleware('checkadmin')->name('libro.create');
Route::post('admin/libros', [LibroController::class, "store"])->middleware('checkadmin')->name("libro.store");

Route::get('/login', [LoginController::class, "index"])->name("login");
Route::post('/login', [LoginController::class, "store"])->name("login.store");
Route::put('/logout', [LoginController::class, "logout"])->name("login.logout");

Route::get('/register', [RegisterController::class, "index"])->name("register.index");
Route::post('/register', [RegisterController::class, "store"])->name("register.store");


Route::get('/contacto', [ContactoController::class, "index"])->name("contacto");

// RUTAS DE RESETEO DE CONTRASEÑA
Route::controller(PasswordResetController::class)->group(function(){
    Route::get('forgot-password', 'create')->name('password.request'); //Muestra el formulario para solicitar el reseto de contraseña
    Route::post('forgot-password', 'store')->name('password.email'); //Envía la solicitud
    Route::get('forgot-password/reset/{token}', 'showResetForm')->name('password.reset'); //Muestra el formulario para cambiar la contraseña
    Route::post('forgot-password/reset', 'reset')->name('password.update'); //Actualiza la contraseña
});

// RUTAS DE MANEJO DEL CARRITO
Route::controller(CarritoController::class)->group(function(){
    Route::post('add-to-cart', 'addCarrito')->middleware('auth')->name('add_to_cart');
    Route::get('cantidadCarrito', 'showCantidad')->middleware('auth')->name('cantidadCarrito');
    Route::get('offcanvas-cart-content', 'getContent')->middleware('auth')->name('offcanvas-cart-content');
    Route::put('update-cart', 'updateCart')->middleware('auth')->name('carrito.update');
    Route::delete('delete-to-cart/{id}', 'deleteToCart')->middleware('auth')->name('delete_to_cart');
    Route::delete('delete-cart', 'vaciarCarrito')->middleware('auth')->name('vaciar-carrito');
    Route::get('carrito', 'showCart')->middleware('auth')->name('show-cart');
    Route::get('detalles-envio', 'showDetallesEnvio')->middleware('auth')->name('show-detalles-envio');
    Route::post('carrito/compra-finalizada', 'shop')->middleware('auth')->name('compra-finalizada');
});

//RUTAS DE MANEJO DE LAS DIRECCIONES
Route::controller(DireccionController::class)->group(function(){
    Route::delete('perfil/deleteAddress/{user}/{direccion}', 'destroy')->name('delete-address');
    Route::put('perfil/update-principal-address/{user}', 'updatePrincipalAddress')->name('update-principal-address');
    Route::get('new_address_process', 'create')->middleware('auth')->name('address.create');
    Route::post('perfil/new_address', 'store')->middleware('auth')->name('store.address');
    Route::get('perfil/address/{user}/{direccion}', 'edit')->name('edit.address');
    Route::put('perfil/address/{direccion}/update-address', 'update')->middleware('auth')->name('update.address');
});

//RUTAS DE MANEJO DE LOS PEDIDOS
Route::controller(PedidoController::class)->group(function(){
    Route::get("mis-pedidos", 'showPedidos')->middleware('auth')->name('show.orders');
    Route::get("ultimos-pedidos", 'getUltimosPedidos')->middleware('auth')->middleware('checkadmin')->name('show.last-orders');
    Route::get("/admin/pedidos", "showAllOrders")->middleware("checkadmin")->name("showAll.orders");
    Route::get("/admin/pedido/{pedido}", "edit")->middleware('checkadmin')->name("edit.order");
    Route::get("pedidos-cancelados", "showPedidosCancelados")->middleware('auth')->name('show.cancelOrders');
    Route::put("cancelar-pedido/{idPedido}", "cancelaPedido")->middleware('auth')->name('order.cancel');
    Route::put("/admin/actualizarEstado/{pedido}", "update")->middleware('checkadmin')->name("update.order");
    Route::delete("/admin/delete-order/{pedido}", "destroy")->middleware("checkadmin")->name("order.destroy");
});

//RUTAS PARA MANEJO DE LA WISHLIST
Route::controller(WishlistController::class)->group(function(){
    Route::post('add-to-wishlist/{libro}', 'addToWishlist')->middleware('auth')->name('add_to_wishlist');
    Route::delete('delete-to-wishlist/{libro}', 'deleteToWishlist')->middleware('auth')->name('delete_to_wishlist');
    Route::get('wishlist', 'show')->middleware('auth')->name('show.wishlist');
});

//RUTAS PARA MANEJO DE LOS POSTS
Route::controller(PostController::class)->group(function(){
    Route::get('blog', 'showBlog')->name("blog");
    Route::get('blog/{slug}', 'showPost')->name("show.post");
    Route::get('blog/categorias/{categoria}', 'showPostsCategory')->name("show.categoria");
    Route::get('admin/posts', 'showAllPosts')->middleware("checkadmin")->name("admin.posts");
    Route::get('admin/posts/{post}/edit', 'edit')->middleware("checkadmin")->name("edit.post");
    Route::get('admin/ultimos-posts', 'getPosts')->middleware("checkadmin")->name("showAll.posts");
    Route::get('admin/post/create', 'create')->middleware('checkadmin')->name("post.create");
    Route::post('blog/{post}/add-comment', 'addComment')->middleware('auth')->name("add.comment");
    Route::post('admin/posts/add-post', 'store')->middleware('checkadmin')->name('store.post');
    Route::delete('admin/delete-post/{post}', 'destroy')->middleware('checkadmin')->name('post.destroy');
    Route::delete('admin/post/delete-comment/{comentario}', 'deleteComment')->middleware('checkadmin')->name('comment.destroy');
    Route::put('admin/posts/{post}/edit', 'update')->middleware('checkadmin')->name('update.post');
});

//RUTAS PARA EL MANEJO DE LAS PROVINCIAS
Route::controller(ProvinciaController::class)->group(function(){
    Route::get('admin/provincias', 'show')->middleware('checkadmin')->name('provincias.show');
    Route::get('admin/provincias-all', 'getProvincias')->middleware('checkadmin')->name('provincias.showAll');
    Route::get('admin/provincia/create', 'create')->middleware('checkadmin')->name('provincia.create');
    Route::post('admin/provincia/add-provincia', 'store')->middleware('checkadmin')->name('provincia.store');
});

//RUTAS PARA EL MANEJO DE LAS TAREAS DEL USUARIO
Route::controller(TareaController::class)->group(function(){
    Route::get('admin/tareas', 'getTareas')->middleware('checkadmin')->name('tareas.get');
    Route::get('admin/calendario', 'showCalendar')->middleware('checkadmin')->name('calendar.show');
    Route::post('admin/calendario/add-task', 'store')->middleware('checkadmin')->name('tarea.store');
    Route::put('admin/calendario/modify-task', 'update')->middleware('checkadmin')->name('tarea.update');
    Route::delete('admin/calendario/delete-task', 'destroy')->middleware('checkadmin')->name('tarea.destroy');
});

//RUTAS PARA MANEJO DE EMAILS
// Route::controller(MailController::class)->group(function(){
//     Route::post('suscribe-newstler', 'sendEmailSuscribeNewstler')->name('suscribe.newstler');
// });

Route::controller(NewsletterController::class)->group(function(){
    Route::post('suscribe-newstler', 'suscribeNewstler')->name('suscribe.newstler');
    Route::get('desuscribir-newsletter/{user}', 'destroyNewsletterView')->middleware('auth')->name('newsletter.destroy-view');
    Route::get('desuscribir-newsletter', 'destroyNewsletterNoAccountView')->name('newsletter.destroy-no-account-view');
    Route::post('desuscribir-newsletter', 'unsuscribeEmail')->name('unsuscribe.newsletter.sendEmail');
    Route::get('desuscribir-newsletter/{token}/{email}', 'unsuscribeNoAccount')->name('unsuscribeNoAccount.newsletter');
    Route::delete('desuscribir-newsletter', 'unsuscribe')->name('unsuscribe.newsletter');
});