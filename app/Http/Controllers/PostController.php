<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Comentario;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class PostController extends Controller{

    public function create(){
        $categorias = Categoria::all();
        return view("blog.post-create", compact('categorias'));
    }

    public function store(Request $request){
        // dd($request);
        $request->validate([
            "titulo" => "required|max:120|unique:posts,nombre",
            "slug" => "required",
            "cuerpo" => "required",
            "portada" => "required|image|mimes:jpeg,jpg,png|max:2048",
            "categoria" => "required"
        ]);

        DB::beginTransaction();
        try {
            $post = new Post();        
            $file = $request->portada; //Obtenemos los datos del archivo subido
            $destinationPath = "uploads/posts/"; //Se define la ruta donde se guardará el archivo subido
            $thumbnailPath = $destinationPath . "thumbnails/"; //Ruta de las miniaturas
            $filename = time() . "-" . $file->GetClientOriginalName() ;//concatenamos el nombre del archivo con el tiempo en ms para que no se repita ningún archivo
            $uploadSuccess = $request->file('portada')->move($destinationPath, $filename);//Movemos el archivo a la carpeta correspondiente
            $post->portada = $destinationPath . $filename;//Subimos el archivo a la base de datos

            $this->resizeImage($destinationPath, $thumbnailPath, $filename, 640, 427);
           
            $post->thumbnail = $thumbnailPath . "thumbnail-" . $filename;
            $post->nombre = $request->titulo;
            $post->slug = $request->slug;
            $post->cuerpo = $request->cuerpo;
            $post->user_id = Auth::user()->id;
            $post->categoria_id = Categoria::where('nombre', $request->categoria)->first()->id;
            $post->save();
            DB::commit();
            return redirect()->route('admin.posts')->with("message", "El post ha sido creado correctamente");
        } catch (\Throwable $e) {
            return $e;
            // return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
        }
    }

    private function resizeImage($destinationPath, $thumbnailPath, $filename, $width, $height) {
        $img = Image::make($destinationPath . $filename); 
        $img->fit($width, $height);
        $img->save($thumbnailPath . "thumbnail-" . $filename);
    }

    public function showBlog(){
        $generos = LibroController::getGeneros();
        //Obtiene los 3 últimos post de la categoría Destacados
        $postsDestacados = Post::where('categoria_id', '5')->latest()->take(3)->get();
        $ultimasResenas = Post::orderby('created_at', 'desc')->take(6)->get();
        return view('blog.blog', compact('generos', 'postsDestacados', 'ultimasResenas'));
    }

    public function showPost($slug){
        $generos = LibroController::getGeneros();
        $post = Post::where('slug', $slug)->first();
        $postsMismaCategoria = Post::where('categoria_id', $post->categoria->id)->where('nombre', '!=', $post->nombre)->take(3)->get();
        $comentarios = $post->comentarios;
        return view('blog.post', compact('post', 'postsMismaCategoria', 'comentarios', 'generos'));
    }

    public function getPosts(Request $request){
        if ($request->ajax()) {
            $posts = Post::orderby('id', 'desc')->get();
            return datatables()->of($posts)
            ->addColumn('user_id', function($post){
                return $post->user->username;
            })
            ->addColumn('categoria_id', function($post){
                return $post->categoria->nombre;
            })
            ->addColumn('action', function($post){
                $btn="<div class='d-flex align-items-center justify-content-center gap-2'>
                <button type='button' id='btn-delete' data-id='$post->id' class='d-flex gap-2 btn-delete text-white btn-delete-user' title='Eliminar post' data-bs-toggle='modal' data-bs-target='#modal-delete' >
                    <i class='bi bi-trash3'></i> 
                </button>

                <a href='". route('edit.post', $post) ."' class='d-flex gap-2 btn-modify text-white' title='Editar post'>
                    <i class='bi bi-pencil-square'></i></a>
            </div>";
            return $btn;
            })
            ->toJson();
        }
        return redirect()->back();
    }

    public function showAllPosts(){
        return view("admin.posts");
    }

    public function addComment(Request $request, Post $post){
        $request->validate([
            "comentario" => "required"
        ]);

        DB::beginTransaction();
        try {
            $comentario = new Comentario();
            $comentario->cuerpo = $request->comentario;
            $comentario->post_id = $post->id;
            $comentario->user_id = Auth::user()->id;
            $comentario->save();
            DB::commit();
            return redirect()->back()->with("message", "Comentario añadido correctamente");
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
        }
    }

    public function destroy(Post $post){
        // dd($post);
        DB::beginTransaction();
        try {
            unlink($post->portada);
            unlink($post->thumbnail);
            $post->delete();
            DB::commit();
            return redirect()->back()->with("message", "El post ha sido eliminado correctamente");
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
        }
    }
}
