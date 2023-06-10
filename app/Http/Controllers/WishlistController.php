<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\WishList;
use App\Models\WishListLibro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    public function addToWishlist(Libro $libro){
        $wishlist = $this->compruebaEliminadosWishlist();
        if (!array_key_exists($libro->id, $wishlist)) { //Si el libro no está añadido a la wishlist
            $wishlist[$libro->id] = [
                "titulo"=>$libro->titulo,
                "autor"=>$libro->autor,
                "portada"=>$libro->portada,
                "stock" => $libro->stock,
                "precio"=>$libro->precio,
            ];
            session()->put('wishlist', $wishlist);
            Cookie::queue("cookie-wishlist-" . Auth::id(), serialize(session()->get('wishlist')), 60*24*30);
            return redirect()->back()->with("message", "El libro ha sido añadido a la lista de deseos");
        }
        else{
            return redirect()->back();
        }
    }

    public function deleteToWishlist(Request $request, $idLibro){
        $libro = Libro::where('id', $idLibro)->first();
        $wishlist = Auth::user()->wishlist;
        DB::beginTransaction();
        try {
            if ($this->libroWishlistExist($wishlist, $libro)) {
                $item = WishListLibro::where('wishlist_id', $wishlist->id)->where('libro_id', $idLibro);
                $item->delete();

                DB::commit();
                if ($request->ajax()) {
                    return response()->json(['message' => 'El libro se ha eliminado de tu lista de deseos correctamente']);
                }
                return redirect()->back();
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            if ($request->ajax()) {
                session()->flash('message_error', 'Ha ocurrido un error inesperado');
            }
            else{
                return redirect()->back()->with('message_error', 'Ha ocurrido un error inesperadoo');
            }
        }
    }

    public function show(){
        $wishlistItems = (Auth::user()->wishlist == null) ? [] : WishListLibro::where('wishlist_id', Auth::user()->wishlist->id)->paginate(5);
        return view('wishlist.show', compact('wishlistItems'));
    }

    public function libroWishlistExist($wishlist, $libro){
        if ($wishlist == null) {
            $exists = false;
        }
        else{
            $exists = (WishListLibro::where('wishlist_id', $wishlist->id)->where('libro_id', $libro->id)->first() == null) ? false : true;
        }
        return $exists;
    }
}
