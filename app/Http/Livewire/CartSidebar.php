<?php

namespace App\Http\Livewire;

use App\Models\Libro;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CartSidebar extends Component
{
    public $carrito;
    public $items;
    public $total;
    protected $listeners = ['refreshCart'=>'$refresh'];
    public function mount(){
        $this->carrito = Auth::user()->carrito;
        if ($this->carrito != null) {
            $this->items = $this->carrito->items;
            $this->total = $this->carrito->items->sum('subtotal');
        }
    }


    public function deleteToCart($IDlibro){
        // dd($IDlibro);
        // $libro = Libro::where('id', $IDlibro)->first();
        // dd($libro);
        $this->emit('deleteToCartEvent', $IDlibro);
    }

    public function render()
    {
        if ($this->carrito != null) {
            $this->items = $this->carrito->items;
            $this->total = $this->carrito->items->sum('subtotal');
        }
        return view('livewire.cart-sidebar');
    }
}
