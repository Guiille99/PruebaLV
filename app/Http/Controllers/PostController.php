<?php

namespace App\Http\Controllers;

use App\Jobs\SendPostDestacadoEmail;
use App\Mail\PostDestacado;
use App\Models\Categoria;
use App\Models\Comentario;
use App\Models\EmailNewsletter;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller{

    public function create(){
        $categorias = Categoria::all();
        return view("blog.post-create", compact('categorias'));
    }

    public function store(Request $request){
        $request->validate([
            "titulo" => "required|max:120|unique:posts,nombre",
            "slug" => "required",
            "cuerpo" => "required",
            "portada" => "required|image|mimes:jpeg,jpg,png|max:1024",
            "categoria" => "required"
        ]);

        DB::beginTransaction();
        try {
            $post = new Post();        
            $file = $request->portada; //Obtenemos los datos del archivo subido
            //Subo la imagen original y almaceno el objeto
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); //Obtengo el nombre de la img sin la extensión
            $originalPath = Cloudinary::upload($file->getRealPath(),[
                "public_id" => time() . "-" . $filename,
                "folder" => "books/posts"
            ]);
            $post->portada = $originalPath->getSecurePath(); //Obtenemos la url de la imagen subida

            //Subo la imagen redimensionada y almaceno el objeto
            $thumbnailPath = Cloudinary::upload($file->getRealPath(), [
                "public_id" => time() . "-" . $filename,
                "transformation" => [
                    "width" => "640",
                    "height" => "427",
                ],
                "folder" => "books/posts/thumbnails"
            ]);

            $post->thumbnail = $thumbnailPath->getSecurePath();

            $post->nombre = $request->titulo;
            $post->slug = $request->slug;
            $post->cuerpo = $request->cuerpo;
            $post->user_id = Auth::user()->id;
            $post->categoria_id = Categoria::where('nombre', $request->categoria)->first()->id;
            $post->save();
            DB::commit();
            if ($post->categoria->nombre == "Destacados") {
                dispatch(new SendPostDestacadoEmail($post));
            }
            return redirect()->route('admin.posts')->with("message", "El post ha sido creado correctamente");
        } catch (\Throwable $e) {
            return redirect()->back()->with("message_error", $e);
        }
    }

    public function edit(Post $post){
        $categorias = Categoria::all();
        $comentarios = $post->comentarios;
        return view('blog.post-edit', compact('post', 'comentarios', 'categorias'));
    }

    public function update(Request $request, Post $post){
        $request->validate([
            "titulo" => "required|max:120",
            "slug" => "required",
            "cuerpo" => "required",
            "categoria" => "required"
        ]);

        if (!$this->compruebaTituloValido($request->titulo, $post->id)) {
            return redirect()->back()->withErrors(['titulo' => 'El valor del campo titulo ya está en uso.']);
        }

        if ($request->hasFile('portada')) {
            $request->validate([
                "portada" => "image|mimes:jpeg,jpg,png|max:1024",
            ]);
            $portadaPublicId = $this->getPublicID($post->portada, true);
            $thumbnailPublicId = $this->getPublicID($post->thumbnail, false);
            $publicsID = [$portadaPublicId, $thumbnailPublicId];

            foreach ($publicsID as $publicID) {
                Cloudinary::destroy($publicID); //Eliminamos las imágenes de Cloudinary
            }
            $post->portada = $this->uploadImage($request->portada, true);
            $post->thumbnail = $this->uploadImage($request->portada, false);
        }
        
        DB::beginTransaction();
        try {
            $changeCategory = false;
            if ($post->categoria->nombre != "Destacados" && $request->categoria == "Destacados") {
                $changeCategory = true;
            }
            $post->nombre = $request->titulo;
            $post->slug = $request->slug;
            $post->categoria_id = Categoria::where('nombre', $request->categoria)->first()->id;
            $post->cuerpo = $request->cuerpo;

            $post->save();
            DB::commit();
            if ($changeCategory) {
                dispatch(new SendPostDestacadoEmail($post));
            }
            return redirect()->route('admin.posts')->with("message", "El post ha sido actualizado correctamente");
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
        }
    }

    public function showBlog(){
        //Obtiene los 3 últimos post de la categoría Destacados
        $postsDestacados = Post::where('categoria_id', '5')->latest()->take(3)->get();
        $ultimasResenas = Post::orderby('created_at', 'desc')->take(6)->get();
        $categorias = Categoria::all('nombre', 'slug');
        return view('blog.blog', compact('postsDestacados', 'ultimasResenas', 'categorias'));
    }

    public function showPost($slug){
        $post = Post::where('slug', $slug)->first();
        $postsMismaCategoria = Post::where('categoria_id', $post->categoria->id)->where('nombre', '!=', $post->nombre)->take(3)->get();
        $comentarios = $post->comentarios()->orderby('created_at', 'desc')->paginate(5);
        return view('blog.post', compact('post', 'postsMismaCategoria', 'comentarios'));
    }

    public function showPostsCategory($slug){
        $categoria = Categoria::where('slug', $slug)->first();
        $posts = Post::where('categoria_id', $categoria->id)->get();
        return view("blog.posts-categoria", compact("categoria", "posts"));
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

    public function deleteComment(Comentario $comentario){
        DB::beginTransaction();
        try {
            $comentario->delete();
            DB::commit();
            return redirect()->back()->with("message", "El comentario ha sido eliminado correctamente");
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
        }
    }

    public function destroy(Post $post){
        DB::beginTransaction();
        try {
            $portadaPublicId = $this->getPublicID($post->portada, true);
            $thumbnailPublicId = $this->getPublicID($post->thumbnail, false);
            $publicsID = [$portadaPublicId, $thumbnailPublicId];

            foreach ($publicsID as $publicID) {
                Cloudinary::destroy($publicID); //Eliminamos las imágenes de Cloudinary
            }
            $post->delete();
            DB::commit();
            return redirect()->back()->with("message", "El post ha sido eliminado correctamente");
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
        }
    }

    private function getPublicID($url, $isPortada){ //Función que genera el public id de la imagen
        $parts = explode("/", $url);
        $filename = explode(".", array_pop($parts))[0];
        $parentPath = ($isPortada) ? "books/posts/" : "books/posts/thumbnails/";
        $publicID = urldecode($parentPath . $filename);
        return $publicID;
    }

    private function uploadImage($file, $isPortada){
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); //Obtengo el nombre de la img sin la extensión
        if ($isPortada) {
            $imagePath = Cloudinary::upload($file->getRealPath(),[
                "public_id" => time() . "-" . $filename,
                "folder" => "books/posts"
            ]);
        }
        else{
            $imagePath = Cloudinary::upload($file->getRealPath(),[
                "public_id" => time() . "-" . $filename,
                "transformation" => [
                    "width" => "640",
                    "height" => "427",
                ],
                "folder" => "books/posts/thumbnails"
            ]);
        }
        return $imagePath->getSecurePath();
    }

    private function compruebaTituloValido($newTitulo, $idPost){
        $titulos = Post::where('nombre', $newTitulo)->whereNot('id', $idPost)->get();
        return (count($titulos) == 0) ? true : false; 
    }
}
