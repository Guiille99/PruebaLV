<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class WishlistComponent extends Component
{
    public $libro;
    public $wishlist;
    // public $message;


    public function mount($libro){
        $this->libro = $libro;
        $this->wishlist = session()->get('wishlist'); //Obtengo la sesión del carrito
    }

    public function addToWishlist(){
        $this->wishlist[$this->libro->id] = [
            "titulo"=>$this->libro->titulo,
            "autor"=>$this->libro->autor,
            "portada"=>$this->libro->portada,
            "stock" => $this->libro->stock,
            "precio"=>$this->libro->precio,
        ];
        session()->put('wishlist', $this->wishlist);
        Cookie::queue("cookie-wishlist-" . Auth::id(), serialize(session()->get('wishlist')), 60*24*30);
        $this->emitTo('wishlist-component-icon', 'refreshComponent');
        // $this->message = session()->get('message', 'hola');
        // $this->success();
        $this->dispatchBrowserEvent('toggle-wishlist', ['message' => 'Libro añadido a la lista de deseos']);
    }

    public function deleteToWishlist(){
        if (array_key_exists($this->libro->id, $this->wishlist)) {
            unset($this->wishlist[$this->libro->id]);
            session()->put('wishlist', $this->wishlist); //Actualizamos la wishlist
            Cookie::queue("cookie-wishlist-" . Auth::id(), serialize(session()->get('wishlist')), 60*24*30);
            $this->emitTo('wishlist-component-icon', 'refreshComponent');
            $this->dispatchBrowserEvent('toggle-wishlist', ['message' => 'Libro eliminado de la lista de deseos']);
        }
        
    }

    public function render()
    {
        return view('livewire.wishlist-component');
    }
}
