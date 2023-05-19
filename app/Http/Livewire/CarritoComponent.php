<?php

namespace App\Http\Livewire;

use App\Http\Controllers\CarritoController;
use App\Models\Carrito;
use App\Models\CarritoLibro;
use App\Models\Libro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CarritoComponent extends Component
{

    protected $listeners = ['deleteToCartEvent'=>'deleteToCart'];

    public $libro;

    public function mount($libro){
        $this->libro = $libro;
    }

    public function addCarrito($libroId){
        $libro = Libro::where('id', $libroId)->first();
        $carrito = Auth::user()->carrito;
        DB::beginTransaction();

        try {
            if ($carrito == null) {
                $carrito = new Carrito();
                $carrito->user_id = Auth::id();
                $carrito->save();
            }
            else{
                $carrito = Auth::user()->carrito;
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
            // $this->dispatchBrowserEvent();
        } catch (\Throwable $e) {
            DB::rollBack();
        }
    }

    public function vaciarCarrito(){
        session()->forget('carrito'); //Eliminamos el carrito
        session()->forget('carrito-data'); //Eliminamos el precio total y la cantidad de libros almacenamos en el carrito
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

        return redirect()->back()->with('message', 'Carrito actualizado');
    }

    public function deleteToCart($IDlibro){ //Eliminar un libro del carrito
   
        $carrito = Carrito::where('user_id', Auth::id())->first();
        $libro = Libro::where('id', $IDlibro)->first();
        // dump($carrito);
        // dd($libro);
        $item = CarritoLibro::where('carrito_id', $carrito->id)->where('libro_id', $libro->id)->first();
        // dd($item);
        if ($item) {
            $item->delete();
        }
    }

    private function libroCartExists($carrito, $libro){
        $exists = (CarritoLibro::where('carrito_id', $carrito->id)->where('libro_id', $libro->id)->first() == null) ? false : true;
        return $exists;
    }

    public function render()
    {
        $this->emit('refreshCart');
        return view('livewire.carrito-component');
    }
}
