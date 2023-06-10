<?php

namespace App\Http\Controllers;

use App\Jobs\SendPedidoEmail;
use App\Models\Carrito;
use App\Models\CarritoLibro;
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
            $carrito = Auth::user()->carrito; //Obtengo el carrito
            DB::beginTransaction();

            try {
                if ($carrito == null) {
                    $carrito = new Carrito();
                    $carrito->user_id = Auth::id();
                    $carrito->save();
                }
    
                if ($this->libroCartExists($carrito, $libro)) { //Si el libro ya está en el carrito
                    $item = CarritoLibro::where('carrito_id', $carrito->id)->where('libro_id', $libro->id)->first();
                    $item->cantidad = $item->cantidad + 1;
                    $item->subtotal = $item->libro->precio * $item->cantidad;
                }
                else{ //si el libro no está en el carrito
                     $item = new CarritoLibro();
                     $item->carrito_id = $carrito->id;
                     $item->libro_id = $libro->id;
                     $item->cantidad = 1;
                     $item->subtotal = $libro->precio;
                }
                $item->save();
                DB::commit();
                return response()->json([
                    "cantidad" => CarritoController::getCantidad($carrito)
                ])->header('Content-Type', 'application/json');
            } catch (\Throwable $e) {
                DB::rollBack();
                return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
            }     
        }
        return redirect()->back();
    }

    public function vaciarCarrito(){
        DB::beginTransaction();
        try {
            CarritoLibro::where('carrito_id', Auth::user()->carrito->id)->delete();
            DB::commit();
            return redirect()->back()->with('message', 'Has vaciado la cesta de la compra');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
        }  
    }

    public function updateCart(Request $request){
        $carrito = Auth::user()->carrito;
        DB::beginTransaction();
        try {
            foreach ($request->request as $id => $newCantidad) {
                $item = $carrito->items->where('libro_id', $id)->first();
                if (is_numeric($id) && $item->cantidad != $newCantidad) { //Si es un número y la cantidad es diferente a la que tenía
                    $item->cantidad = $newCantidad;
                    $item->subtotal = $item->libro->precio * $item->cantidad;
                    $item->save();
                }
            }
            DB::commit();
            return redirect()->back()->with('message', 'Carrito actualizado');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
        }
    }

    public static function deleteToCart(Request $request, $IDlibro){ //Eliminar un libro del carrito
        $carrito = Auth::user()->carrito;
        $item = CarritoLibro::where('carrito_id', $carrito->id)->where('libro_id', $IDlibro);
        DB::beginTransaction();
        try {
            $item->delete();
            DB::commit();
            if ($carrito->items->count() == 0) {
                if (request()->ajax()) {
                    return response()->json(['message' => 'Has vaciado la cesta de la compra']);
                }
                return redirect()->back()->with('message', 'Has vaciado la cesta de la compra');
            }
            if ($request->ajax()) {
                return response()->json(['message'=>'Has eliminado el libro correctamente']);
            }

            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
        }
    }

    public function showCart(){
        return view("carrito.show-cart");
    }

    public function showCantidad(){
        // $carrito = session()->get('carrito', []); //Obtengo la sesión del carrito
        
        // return count($carrito);
        $carritoData = session()->get('carrito-data');
        return $carritoData["cantidad"];
    }

    public function getContent(Request $request){
        if($request->ajax() && $request->input("token")){ //Si recibimos el token
            $carrito = Auth::user()->carrito;
            $total = $carrito->items->sum('subtotal');
            return view("carrito.offcanvas-cart-content", compact("carrito", "total"));
        }
        return redirect()->back();
    }
    
    public static function getCantidad($carrito){
        $cantidad = $carrito->items->sum('cantidad');
        return $cantidad;
    }
    public static function getTotal(){
        $total = 0;
        if (Auth::user()->carrito != null) {
            $total = Auth::user()->carrito->items->sum('subtotal');
        }
        return $total;
    }

    public function showDetallesEnvio(){
        $provincias = Provincia::select('nombre')->orderby('nombre', 'asc')->get();
        $total = Auth::user()->carrito->items->sum('subtotal');
        return view("carrito.detalles-envio", compact("provincias", "total"));
    }

    public function shop(Request $request){
        if (Auth::user()->carrito == null || Auth::user()->carrito->items->count() == 0) {
            return redirect()->route('show-cart');
        }
        DB::beginTransaction();
        try {
            //Registramos el pedido
            $pedido = new Pedido();
            $pedido->total = CarritoController::getTotal();
            $pedido->tipo_pago = $request->metodo;
            $pedido->user_id = Auth::user()->id;
            $pedido->direccion_id = $request->direccion;
            $pedido->save();
    
            foreach (Auth::user()->carrito->items as $item) {
                $libro = Libro::where("id", $item->libro_id)->first();
                $libro->stock -= $item->cantidad;
                $libro->save();
                $pedido->libros()->attach($libro->id, ["precio"=>$libro->precio, "cantidad"=>$item->cantidad, "subtotal"=>$item->subtotal]);
            }
    
            CarritoLibro::where('carrito_id', Auth::user()->carrito->id)->delete();
            DB::commit();
            dispatch(new SendPedidoEmail(Auth::user()->email, $pedido));
            return view("carrito.compra-finalizada");
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
        }
    }

    public function libroCartExists($carrito, $libro){
        $exists = (CarritoLibro::where('carrito_id', $carrito->id)->where('libro_id', $libro->id)->first() == null) ? false : true;
        return $exists;
    }
}
