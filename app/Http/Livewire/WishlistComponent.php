<?php

namespace App\Http\Livewire;

use App\Models\Wishlist;
use App\Models\WishListLibro;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class WishlistComponent extends Component
{
    public $libro;
    public $wishlist;
    // public $message;


    public function mount($libro){
        $this->libro = $libro;
        if (Auth::check()) {
            $this->wishlist = Auth::user()->wishlist; //Obtengo la sesión del carrito
        }
    }

    public function addToWishlist(){
        DB::beginTransaction();
        try {
            if ($this->wishlist == null) {
                $this->wishlist = new Wishlist();
                $this->wishlist->user_id = Auth::id();
                $this->wishlist->save();
            }
            if (!$this->libroWishlistExist($this->wishlist, $this->libro)) { //Si el libro no está en la wishlist
                $item = new WishListLibro();
                $item->wishlist_id = $this->wishlist->id;
                $item->libro_id = $this->libro->id;
                $item->save();
            }
            DB::commit();
            $this->dispatchBrowserEvent('toggle-wishlist', ['message' => 'Libro añadido a la lista de deseos']);
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->dispatchBrowserEvent('wishlist-error', ['message' => 'Ha ocurrido un error inesperado']);
        }

        $this->emitTo('wishlist-component-icon', 'refreshComponent');
    }

    public function deleteToWishlist(){
        DB::beginTransaction();
        try {
            if ($this->libroWishlistExist($this->wishlist, $this->libro)) {
                WishListLibro::where('wishlist_id', $this->wishlist->id)->where('libro_id', $this->libro->id)->delete();
            }
            DB::commit();
            $this->emitTo('wishlist-component-icon', 'refreshComponent');
            $this->dispatchBrowserEvent('toggle-wishlist', ['message' => 'Libro eliminado de la lista de deseos']);
        } catch (\Throwable $e) {
            DB::rollBack();
            // session()->flash('message_error', 'Ha ocurrido un error inesperado');
            $this->dispatchBrowserEvent('wishlist-error', ['message' => 'Ha ocurrido un error inesperado']);
        }
    }

    private function libroWishlistExist($wishlist, $libro){
        if ($wishlist == null) {
            $exists = false;
        }
        else{
            $exists = (WishListLibro::where('wishlist_id', $wishlist->id)->where('libro_id', $libro->id)->first() == null) ? false : true;
        }
        return $exists;
    }

    public function render()
    {
        $libroWishlistExists = $this->libroWishlistExist($this->wishlist, $this->libro);
        return view('livewire.wishlist-component', compact("libroWishlistExists"));
    }
}
