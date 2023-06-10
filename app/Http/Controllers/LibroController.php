<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libro;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LibroController extends Controller
{ 
    public function index(Request $request){
        $libros = Libro::select('id', 'titulo', 'autor', 'editorial', 'stock', 'fecha_publicacion', 'precio', 'genero', 'valoracion', 'created_at', 'updated_at')->get();
        if ($request->ajax()) {
        return datatables()->of($libros)
        ->addColumn('action', function($libro){
            $btn="<div class='d-flex align-items-center gap-2'>
            <button type='button' class='d-flex gap-2 btn-delete text-white' title='Eliminar libro' data-id='$libro->id' data-titulo='$libro->titulo' data-bs-toggle='modal' data-bs-target='#modal-delete' >
                <i class='bi bi-trash3'></i> 
            </button>

            <a href='". route('libro.edit', $libro) ."' class='d-flex gap-2 btn-modify text-white' title='Editar libro'>
                <i class='bi bi-pencil-square'></i></a>
        </div>";
            return $btn;
        })
        ->toJson();
        }
        return view("admin.libros", compact("libros"));
    }

    public static function getGeneros(){
        $generos = Libro::select('genero')->distinct()->orderby('genero')->get();
        foreach ($generos as $genero) {
            if (strpos($genero->genero, "/")!="") { //Si se encuentra / en el nombre del género lo sustituiremos para evitar errores
                $genero->genero = str_replace(["/"], "-", $genero->genero);
            }
        }

        return $generos;
    }

    public function filter($filtro){
        $generos = Libro::select('genero')->distinct()->get();
        $filtraGenero=false;
        foreach ($generos as $genero) {
            if (strtolower($genero->genero) == strtolower($filtro)) {   
                $filtraGenero=true;
            }
            if (strpos($genero->genero, "/")!="") { //Si se encuentra / en el nombre del género lo sustituiremos para evitar errores
                $genero->genero = str_replace(["/"], "-", $genero->genero);
            }
        }
    

        if ($filtraGenero) { //Si se quiere filtrar por categoría
            $libros = Libro::where('genero', $filtro)->paginate(5); //Libros de una determinada categoría
        }
        else if (strtolower($filtro)=="novedades") {
            $libros = Libro::orderby('fecha_publicacion', 'desc')->take(100)->paginate(12); //Si se quieren obtener los libros más recientes   
        }
        else{
            $libros = Libro::where('titulo', 'like', '%'.$filtro.'%')->orWhere('autor', 'like', '%'.$filtro.'%')->paginate(5); //Libros filtrados por título o autor
        }
        return view("libros.index", compact("generos", "libros", "filtro"));
    }

    public function getFiltro(Request $request){
        return redirect()->route('libros.filter', $request->filtro); //Envío el filtro recogido en la barra de búsqueda y lo envío
    }

    public function destroy(Request $request, Libro $libro){ 
        DB::beginTransaction();
        try {
            $carritoController = new CarritoController();
            $wishlistController = new WishlistController();
            $carrito = Auth::user()->carrito;
            if ($carrito != null && $carritoController->libroCartExists($carrito, $libro)) { //Si el libro está en el carrito
                CarritoController::deleteToCart($request, $libro->id);
            }

            $wishlist = Auth::user()->wishlist;
            if ($wishlist != null && $wishlistController->libroWishlistExist($wishlist, $libro)) { //Si el libro está en la wishlist
                $wishlistController->deleteToWishlist($request, $libro->id);
            }
            $publicID = $this->getPublicID($libro->portada);
            Cloudinary::destroy($publicID); //Elimina la imagen
            $libro->delete(); //Elimina el libro
            DB::commit();
            return redirect()->route('libros.index')->with("message", "Libro eliminado correctamente");
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
        }
    }

    public function edit(Libro $libro){ 
        return view("libros.edit", compact('libro'));
    }

    public function create(){
        return view("libros.create");
    }

    public function store(Request $request){
        $request->validate([ //Validación de campos
            "titulo" => "required|min:2|max:150",
            "autor" => "required|min:2|max:100",
            "editorial" => "required|min:2|max:80",
            "isbn" => "required|min:14|max:17|unique:libros",
            "portada" => "required|image|mimes:jpeg,jpg,png|max:350",
            "fecha_publicacion" => "required",
            "precio" => "required",
            "genero" => "required|min:2|max:40",
            "descripcion" => "required|min:5|max:600",
            "valoracion" => "numeric|min:1|max:10",
            "paginas" => "required",
            "stock" => "required",
        ]);

        DB::beginTransaction();

        try {
            $libro = new Libro();
    
            if($request->hasFile('portada')){
                $file = $request->file('portada');//Obtenemos los datos del archivo subido
                $libro->portada = $this->uploadImage($file); //Subimos la imagen y almacenamos la url
            }
    
            $libro->titulo = $request->titulo;
            $libro->autor = $request->autor;
            $libro->editorial = $request->editorial;
            $libro->isbn = $request->isbn;
            $libro->fecha_publicacion = $request->fecha_publicacion;
            $libro->precio = $request->precio;
            $libro->genero = $request->genero;
            $libro->descripcion = $request->descripcion;
            $libro->valoracion = $request->valoracion;
            $libro->paginas = $request->paginas;
            $libro->stock = $request->stock;
    
            $libro->save();
            DB::commit();
            return redirect()->route('libros.index')->with("message", "Libro añadido correctamente");
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
        }

    }


    public function update(Request $request, Libro $libro){ 
        $request->validate([ //Validación de campos
            "titulo" => "required|min:2|max:150",
            "autor" => "required|min:2|max:100",
            "editorial" => "required|min:2|max:80",
            "isbn" => "required|min:14|max:17",
            "fecha_publicacion" => "required",
            "precio" => "required",
            "genero" => "required|min:2|max:40",
            "descripcion" => "required|min:5|max:600",
            "valoracion" => "numeric|min:1|max:10",
            "paginas" => "required",
            "stock" => "required",
        ]);
        if ($request->has("portada")) {
            $request->validate([
                "portada" => "image|mimes:jpeg,jpg,png|max:350",
            ]);
        }

        DB::beginTransaction();
        try {
            $isbns = Libro::select('isbn')->where('isbn', $request->isbn)->whereNot('isbn', $libro->isbn)->get();
            if (count($isbns) != 0) {
                return redirect()->route('libro.edit', $libro)->withErrors([
                    "isbn" => "La ISBN ya está en uso"
                ]);
            }
    
            if($request->hasFile('portada')){
                $publicID = $this->getPublicID($libro->portada);
                Cloudinary::destroy($publicID);
                $libro->portada = $this->uploadImage($request->portada);
            }
                    
            $libro->titulo = $request->titulo;
            $libro->autor = $request->autor;
            $libro->editorial = $request->editorial;
            $libro->isbn = $request->isbn;
            $libro->fecha_publicacion = $request->fecha_publicacion;
            $libro->precio = $request->precio;
            $libro->genero = $request->genero;
            $libro->descripcion = $request->descripcion;
            $libro->valoracion = $request->valoracion;
            $libro->paginas = $request->paginas;
            $libro->stock = $request->stock;
    
    
            $libro->save();
            DB::commit();
            return redirect()->route('libros.index')->with("message", "Libro actualizado correctamente");
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
        }

    }

    public function show(Libro $libro){
        return view("libros.show", compact('libro'));
    }

    private function uploadImage($file){
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); //Obtengo el nombre de la img sin la extensión
        $imagePath = Cloudinary::upload($file->getRealPath(),[
            "public_id" => time() . "-" . $filename,
            "folder" => "books/libros"
        ]);
        return $imagePath->getSecurePath();
    }

    private function getPublicID($url){ //Función que genera el public id de la imagen
        $parts = explode("/", $url);
        $filename = explode(".", array_pop($parts))[0];
        $parentPath = "books/libros/";
        $publicID = urldecode($parentPath . $filename);
        return $publicID;
    }

}
