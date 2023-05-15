<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libro;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class LibroController extends Controller
{
 
    public function index(Request $request){
        // $libros = Libro::paginate(5);
        $libros = Libro::select('id', 'titulo', 'autor', 'editorial', 'stock', 'fecha_publicacion', 'precio', 'genero', 'valoracion', 'created_at', 'updated_at')->get();
        if ($request->ajax()) {
            // dump($request->ajax());
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
        $generos = Libro::select('genero')->distinct()->get();
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

    public function destroy(Libro $libro){ 
        // unlink($libro->portada);//Borra la anterior foto registrada
        $publicID = $this->getPublicID($libro->portada);
        Cloudinary::destroy($publicID);
        dd($publicID);
        // $libro->delete(); //Elimina el libro
        return redirect()->route('libros.index')->with("message", "Libro eliminado correctamente");
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
            "portada" => "required",
            "fecha_publicacion" => "required",
            "precio" => "required",
            "genero" => "required|min:2|max:40",
            "descripcion" => "required|min:5|max:600",
            "valoracion" => "numeric|min:1|max:10",
            "paginas" => "required",
            "stock" => "required",
        ]);


        $libro = new Libro();

        if($request->hasFile('portada')){
            $file = $request->file('portada');//Obtenemos los datos del archivo subido
            $destinationPath = "uploads/libros/";//Se define la ruta donde se guardará el archivo subido
            $filename = time() . "-" . $file->GetClientOriginalName() ;//concatenamos el nombre del archivo con el tiempo en ms para que no se repita ningún archivo
            $uploadSuccess = $request->file('portada')->move($destinationPath, $filename);//Movemos el archivo a la carpeta correspondiente
            $libro->portada = $destinationPath . $filename;//Subimos el archivo a la base de datos
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
        return redirect()->route('libros.index')->with("message", "Libro añadido correctamente");
    }


    public function update(Request $request, Libro $libro){ 
        $request->validate([ //Validación de campos
            "titulo" => "required|min:2|max:150",
            "autor" => "required|min:2|max:100",
            "editorial" => "required|min:2|max:80",
            "isbn" => "required|min:14|max:17",
            "fecha_publicacion" => "required",
            "precio" => "required",
            "genero" => "required|min:5|max:40",
            "descripcion" => "required|min:5|max:600",
            "valoracion" => "numeric|min:1|max:10",
            "paginas" => "required",
            "stock" => "required",
        ]);

        $isbns = Libro::all('isbn');

        foreach ($isbns as $isbn) {
            if ($isbn->isbn==$request->isbn && $isbn->isbn!=$libro->isbn) {
                return redirect()->route('libro.edit', $libro)->withErrors([
                    "isbn" => "ISBN está en uso"
                ]);
            }
        }

        if($request->hasFile('portada')){
            unlink($libro->portada);//Borra la anterior foto registrada
            $file = $request->file('portada');//Obtenemos los datos del archivo subido
            $destinationPath = "uploads/libros/";//Se define la ruta donde se guardará el archivo subido
            $filename = time() . "-" . $file->GetClientOriginalName() ;//concatenamos el nombre del archivo con el tiempo en ms para que no se repita ningún archivo
            $uploadSuccess = $request->file('portada')->move($destinationPath, $filename);//Movemos el archivo a la carpeta correspondiente
            $libro->portada = $destinationPath . $filename;//Subimos el archivo a la base de datos
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
        return redirect()->route('libros.index')->with("message", "Libro actualizado correctamente");
    }

    public function show(Libro $libro){
        $generos = Libro::select('genero')->distinct()->get();
        return view("libros.show", compact('libro', 'generos'));
    }

    private function getPublicID($url){ //Función que genera el public id de la imagen
        $parts = explode("/", $url);
        $filename = explode(".", array_pop($parts))[0];
        $parentPath = "books/libros/";
        $publicID = urldecode($parentPath . $filename);
        return $publicID;
    }

}
