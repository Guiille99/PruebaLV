<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Pedido;
use App\Models\Provincia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class CarritoController extends Controller
{
    public function addCarrito(Request $request){
        // dd(Auth::id());
        if ($request->ajax() && $request->input("token")) { //Si se ha recibido el token
            $libro = Libro::where('id', $request->input('id'))->first();
            $carrito = session()->get('carrito', []); //Obtengo la sesión del carrito
            $carritoData = session()->get('carrito-data', []);
            // $total = session()->get('total', 0);
    
            if (isset($carrito[$libro->id])) { //Si el libro ya está en el carrito
                $carrito[$libro->id]["cantidad"]++;
            }
            else{ //Si no está en el carrito lo añadimos
                $carrito[$libro->id]=[
                    "titulo"=>$libro->titulo,
                    "autor"=>$libro->autor,
                    "portada"=>$libro->portada,
                    "stock" => $libro->stock,
                    "precio"=>$libro->precio,
                    "cantidad"=>1
                ];
            }
            session()->put('carrito', $carrito); //Actualizamos la sesión
            $carritoData["total"] = CarritoController::getTotal(); //Almacenamos el precio total
            $carritoData["cantidad"] = CarritoController::getCantidad(); //Almacenamos la cantidad total
            session()->put("carrito-data", $carritoData);
            //Almacenamos los datos del carrito en cookies con fecha límite de 1 mes
            Cookie::queue("cookie-cart-" . Auth::id(), serialize(session()->get('carrito')), 60*24*30);
            Cookie::queue("cookie-cartData-" . Auth::id(), serialize(session()->get('carrito-data')), 60*24*30);
        }
        
        return redirect()->back();
    }

    public function vaciarCarrito(){
        session()->forget('carrito'); //Eliminamos el carrito
        session()->forget('carrito-data'); //Eliminamos el precio total y la cantidad de libros almacenamos en el carrito
        //Eliminamos las cookies
        Cookie::queue(Cookie::forget('cookie-cart-'. Auth::id()));
        Cookie::queue(Cookie::forget('cookie-cartData-'. Auth::id()));
        return redirect()->back()->with('message', 'Has vaciado la cesta de la compra');
    }

    public function updateCart(Request $request){
        $carrito = session()->get('carrito');
        foreach ($request->request as $id => $newCantidad) {
            if (is_numeric($id) && $carrito[$id]["cantidad"] != $newCantidad) { //Si es un número y la cantidad es diferente a la que tenía
                $carrito[$id]["cantidad"] = $newCantidad; //Modificamos la cantidad
            }
        }
        
        session()->put('carrito', $carrito);
        $carritoData=session()->get('carrito-data');
        $carritoData["total"] = CarritoController::getTotal();
        $carritoData["cantidad"] = CarritoController::getCantidad();
        session()->put("carrito-data", $carritoData);
        Cookie::queue("cookie-cart-" . Auth::id(), serialize(session()->get('carrito')), 60*24*30);
        Cookie::queue("cookie-cartData-" . Auth::id(), serialize(session()->get('carrito-data')), 60*24*30);

        return redirect()->back()->with('message', 'Carrito actualizado');
    }

    public static function deleteToCart(Request $request, $IDlibro){ //Eliminar un libro del carrito
        $carrito = session()->get('carrito');
        $carritoData = session()->get('carrito-data');
        unset($carrito[$IDlibro]); //Eliminamos el libro del carrito
        session()->put('carrito', $carrito); //Actualizamos el carrito
        $carritoData["total"] = CarritoController::getTotal();
        $carritoData["cantidad"] = CarritoController::getCantidad();
        session()->put("carrito-data", $carritoData);
        Cookie::queue("cookie-cart-" . Auth::id(), serialize(session()->get('carrito')), 60*24*30);
        Cookie::queue("cookie-cartData-" . Auth::id(), serialize(session()->get('carrito-data')), 60*24*30);

        if ($carritoData["cantidad"]==0) { //Si se ha vaciado la cesta retornaremos la vista con un alert
            if ($request->ajax()) { //Si es una petición AJAX
                return response()->json(['message' => 'Has vaciado la cesta de la compra']);
            }
            return redirect()->back()->with('message', 'Has vaciado la cesta de la compra');
        }
        if ($request->ajax()) {
            return response()->json(['message'=>'Has vaciado la cesta de la compra']);
        }
        return redirect()->back();
    }

    public function showCart(){
        $generos = LibroController::getGeneros();
        return view("carrito.show-cart", compact('generos'));
    }

    public function showCantidad(){
        // $carrito = session()->get('carrito', []); //Obtengo la sesión del carrito
        
        // return count($carrito);
        $carritoData = session()->get('carrito-data');
        return $carritoData["cantidad"];
    }

    public function getContent(Request $request){
        if($request->ajax() && $request->input("token")){ //Si recibimos el token
            return view("carrito.offcanvas-cart-content");
        }
        return redirect()->back();
    }
    
    public static function getCantidad(){
        $carrito = session()->get('carrito', []); //Obtengo la sesión del carrito
        $cantidad=0;
        foreach ($carrito as $libro) {
            $cantidad += $libro["cantidad"];
        }
        return $cantidad;
    }
    public static function getTotal(){
        $carrito = session()->get('carrito', []);
        $total = 0;
        if (count($carrito)>0) { //Si hay algún libro en el carrito
            foreach ($carrito as $libro) {
                $total+=$libro["precio"]*$libro["cantidad"];
            }
        }
        return $total;
    }

    public function showDetallesEnvio(){
        $generos = LibroController::getGeneros();
        $provincias = Provincia::select('nombre')->orderby('nombre', 'asc')->get();
        return view("carrito.detalles-envio", compact("generos", "provincias"));
    }

    public function shop(Request $request){
        // dd(session()->get('carrito'));
        $generos = LibroController::getGeneros();
        DB::beginTransaction();
        try {
            //Registramos el pedido
            $pedido = new Pedido();
            $pedido->total = session()->get('carrito-data')["total"];
            $pedido->tipo_pago = $request->metodo;
            $pedido->user_id = Auth::user()->id;
            $pedido->direccion_id = $request->direccion;
            $pedido->save();
    
            foreach (session()->get('carrito') as $id => $libroCart) {
                $libro = Libro::where("id", $id)->first();
                $libro->stock -= $libroCart["cantidad"];
                $libro->save();
                $pedido->libros()->attach($libro->id, ["precio"=>$libro->precio, "cantidad"=>$libroCart["cantidad"], "subtotal"=>$libroCart["precio"]*$libroCart["cantidad"]]);
            }
    
            session()->forget('carrito'); //Eliminamos el carrito
            session()->forget('carrito-data'); //Eliminamos el precio total y la cantidad de libros almacenamos en el carrito
            //Eliminamos las cookies
            Cookie::queue(Cookie::forget('cookie-cart-'. Auth::id()));
            Cookie::queue(Cookie::forget('cookie-cartData-'. Auth::id()));
            DB::commit();
            return view("carrito.compra-finalizada", compact("generos"));
        } catch (\Throwable $e) {
            DB::rollBack();
            return $e->getMessage();
            // return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
        }
    }

    public static function compruebaLibrosEliminados($carrito){
        $cambios = false;
        foreach ($carrito as $idLibro => $datos) {
            $libro = Libro::where('id', $idLibro)->first();
            if ($libro == null) {
                unset($carrito[$idLibro]);
                $cambios = true;
            }
        }
        if ($cambios) { //Si hay cambios actualizamos
            $carritoData = session()->get('carrito-data');
            session()->put('carrito', $carrito); //Actualizamos la sesión
            $carritoData["total"] = CarritoController::getTotal(); //Almacenamos el precio total
            $carritoData["cantidad"] = CarritoController::getCantidad(); //Almacenamos la cantidad total
            session()->put("carrito-data", $carritoData);
        }
    }
}
