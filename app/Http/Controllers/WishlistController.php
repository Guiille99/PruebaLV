<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class WishlistController extends Controller
{
    public function addToWishlist(Libro $libro){
        // session()->forget('wishlist');
        // Cookie::queue(Cookie::forget('cookie-wishlist-'. Auth::id()));
        // dd($libro);
        $wishlist = session()->get('wishlist', []);

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

    public static function deleteToWishlist(Libro $libro){
        $wishlist = session()->get('wishlist');
        if (array_key_exists($libro->id, $wishlist)) {
            unset($wishlist[$libro->id]);
            session()->put('wishlist', $wishlist); //Actualizamos la wishlist
            Cookie::queue("cookie-wishlist-" . Auth::id(), serialize(session()->get('wishlist')), 60*24*30);
            return redirect()->back()->with("message", "El libro ha sido eliminado de la lista de deseos");
        }
        return redirect()->back();
    }

    public function show(){
        $generos = LibroController::getGeneros();
        $wishlist = session()->get('wishlist');
        $collection = collect($wishlist);

        // Paginar la colección de datos
        $perPage = 10;
        $page = request()->get('page', 1);
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $collection->forPage($page, $perPage),
            $collection->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        return view('wishlist.show', ['wishlist'=>$paginator], compact('generos'));
    }

    public static function compruebaEliminadosWishlist($wishlist){
        $cambios = false;
        foreach ($wishlist as $idLibro => $datos) {
            $libro = Libro::where('id', $idLibro)->first();
            if ($libro == null) {
                unset($wishlist[$idLibro]);
                $cambios = true;
            }
        }

        if ($cambios) {
            session()->put('wishlist', $wishlist); //Actualizamos la wishlist
            Cookie::queue("cookie-wishlist-" . Auth::id(), serialize(session()->get('wishlist')), 60*24*30);
        }
    }
}
