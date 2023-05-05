<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class WishlistComponent extends Component
{
    public $wishlist;
    public $libro;

    public function mount($libro){
        $this->libro = $libro;
        $this->wishlist = session()->get('wishlist'); //Obtengo la sesión del carrito
    }
    
    public function addToWishlist()
    {
        // dd($this->libro);
        $this->wishlist[$this->libro->id] = [
            "titulo"=>$this->libro->titulo,
            "autor"=>$this->libro->autor,
            "portada"=>$this->libro->portada,
            "stock" => $this->libro->stock,
            "precio"=>$this->libro->precio,
        ];
        session()->put('wishlist', $this->wishlist);
        Cookie::queue("cookie-wishlist-" . Auth::id(), serialize(session()->get('wishlist')), 60*24*30);
    }

    public function render()
    {
        return view('livewire.wishlist-component');
    }
}
