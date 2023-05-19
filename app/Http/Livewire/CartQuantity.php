<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CartQuantity extends Component
{
    public $cantidad;
    public $carrito;
    protected $listeners = ['refreshCart'=>'$refresh'];
    public function mount(){
        if (Auth::user()->carrito != null) {
            $this->carrito = Auth::user()->carrito;
            $this->cantidad = $this->carrito->items->count();
        }
    }

    public function render()
    {
        return view('livewire.cart-quantity');
    }
}
