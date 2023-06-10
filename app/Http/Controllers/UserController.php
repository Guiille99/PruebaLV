<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Libro;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //Constantes
    const DEFAULT_AVATAR_URL = "https://res.cloudinary.com/det0ae4ke/image/upload/v1684158473/books/avatars/1682946038-default_hhfcep.png";

    public function show(Request $request){ //Listado de todos los usuarios
        $users = User::paginate(5);
        // dd($users);
        if ($request->ajax()) {
            $users = User::all();
            return datatables()->of($users)
        ->addColumn('action', function($user){
            $btn="<div class='d-flex align-items-center gap-2'>
            <button type='button' id='btn-delete' data-id='$user->id' data-username='$user->username' class='d-flex gap-2 btn-delete text-white btn-delete-user' title='Eliminar usuario' data-bs-toggle='modal' data-bs-target='#modal-delete' >
                <i class='bi bi-trash3'></i> 
            </button>

            <a href='". route('user.edit', $user) ."' class='d-flex gap-2 btn-modify text-white' title='Editar usuario'>
                <i class='bi bi-pencil-square'></i></a>
        </div>";
            return $btn;
        })
        ->toJson();
        }
        return view("admin.index", compact('users'));
    }

    public function create(){
        return view("users.create");
    }

    public function store(Request $request){
        $request->validate([ //Validación de campos
            "nombre" => "required|min:2|max:80|",
            "apellidos" => "required|min:2|max:100|",
            "email" => "required|unique:users",
            "username" => "required|min:5|max:25|unique:users",
            "password" => "required|min:5|max:80",
            "avatar" => "image|mimes:jpeg,jpg,png|max:100"
        ]);
        DB::beginTransaction();
        try {
            $user = new User();
            $user->nombre = $request->nombre;
            $user->apellidos = $request->apellidos;
            $user->username = $request->username;
            $user->password =  Hash::make($request->password); //Codificamos la contraseña
            $user->email = $request->email;
            $user->rol = $request->rol;
            if ($request->has('avatar')) {
                $user->avatar = $this->uploadImage($request->avatar);
            }
            else{
                $user->avatar = UserController::DEFAULT_AVATAR_URL;
            }
            $user->save();
            DB::commit();
            return redirect()->route('admin.users')->with("message", "Usuario añadido correctamente");
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
        }
    }

    public function destroyAccountView(User $user){
        return view("users.editPerfil-deleteAccount", compact('user'));
    }

    public function destroyAccountPerfil(Request $request, User $user){
        // dd(Hash::check($request->password, $user->password));
        if (Hash::check($request->password, $user->password)) {
            DB::beginTransaction();
            try {
                $this->destroy($user->id);
                DB::commit();
                return redirect()->back()->with("message", "Usuario eliminado correctamente");
            } catch (\Throwable $e) {
                DB::rollBack();
                return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
            }
        }
        else{
            return redirect()->back()->withErrors(["password"=>"Contraseña incorrecta"]);
        }
    }

    // public function destroy(User $user){ 
    public function destroy($id){ 
        DB::beginTransaction();
        try {
            $user=User::where('id', $id)->first();
            if ($user->avatar != UserController::DEFAULT_AVATAR_URL) {
                $avatarPublicId = $this->getPublicID($user->avatar);
                Cloudinary::destroy($avatarPublicId); //Elimina la imagen de Cloudinary
            }
            $user->delete(); //Elimina el usuario
            DB::commit();
            return redirect()->back()->with("message", "Usuario eliminado correctamente");
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
        }
    }

    public function edit(User $user){ 
        return view("users.edit", compact('user'));
    }

    public function editPerfil(User $user){ 
        return view("users.editPerfil", compact('user'));
    }

    public function myData(User $user){
        return view("users.editPerfil-datos", compact('user'));
    }
    public function myAddresses(User $user){
        $direcciones = $user->direcciones()->orderby('principal', 'desc')->get();
        return view("users.editPerfil-direcciones", compact('user', 'direcciones'));
    }

    public function myAccountPassword(User $user){
        return view("users.editPerfil-password", compact('user'));
    }


    public function updatePerfil(Request $request, User $user){ 
        $request->validate([ //Validación de campos
            "nombre" => "required|min:2|max:80|",
            "apellidos" => "required|min:2|max:100|",
            "username" => "required|min:2|max:25|",
            "email" => "required|email|max:255",
        ]);
        if ($request->hasFile("avatar")) {
            $request->validate([
                "avatar" => "image|mimes:jpeg,jpg,png|max:100"
            ]);
        }
        DB::beginTransaction();
        try {
            if ($request->hasFile("avatar")) { //Si desea cambiar la imagen de perfil
                if ($user->avatar != UserController::DEFAULT_AVATAR_URL) {
                    $avatarPublicId = $this->getPublicID($user->avatar);
                    Cloudinary::destroy($avatarPublicId); //Elimina la imagen de Cloudinary
                }
                $user->avatar = $this->uploadImage($request->avatar); //Subimos la nueva imagen
            }
    
             $emails = User::select('email')->where('email', $request->email)->whereNot('id', $user->id)->get(); //Obtengo todos los emails excluyendo el del usuario
            if (count($emails) != 0) { //Si el email existe y no es el tuyo
                return redirect()->back()->withErrors([
                    "email" => "Este email está en uso"
                ]);   
               
            }
    
            $usuarios = User::select('username')->where('username', $request->username)->whereNot('id', $user->id)->get();
            if (count($usuarios) != 0) {
                return redirect()->route('user.edit')->withErrors([
                    "username" => "Este usuario está en uso"
                ]);   
                
            }
    
            $user->nombre = $request->nombre;
            $user->apellidos = $request->apellidos;
            $user->username = $request->username;
    
            if ($request->password != null) { //Si el campo contraseña no se ha dejado vacío y desea cambiarla
                $request->validate([
                    "password" => "min:5|max:80"
                ]);
                $user->password =  Hash::make($request->password); //Codificamos la contraseña
            }
            $user->email = $request->email;
    
            if ($request->rol!=null) { //Si es nulo significa que viene de actualizar el perfil desde la vista principal, no desde admin
                $user->rol = $request->rol;
            }
    
            $user->save();
            DB::commit();
            return redirect()->back()->with("message", "Usuario actualizado correctamente");
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
        }

    }

    
    public function update(Request $request, User $user){ 
        $request->validate([ //Validación de campos
            "nombre" => "required|min:2|max:80|",
            "apellidos" => "required|min:2|max:100|",
        ]);
        if ($request->hasFile("avatar")) {
            $request->validate([
                "avatar" => "image|mimes:jpeg,jpg,png|max:100"
            ]);
        }
        DB::beginTransaction();
        try {
            $emails = User::select('email')->where('email', $request->email)->whereNot('id', $user->id)->get(); //Obtengo todos los emails excluyendo el del usuario
            if (count($emails) != 0) { //Si el email existe y no es el tuyo
                if ($request->rol==null) { //Si es nulo significa que viene de actualizar el perfil desde la vista principal, no desde admin
                    return redirect()->route('user.edit')->withErrors([
                       "email" => "Este email está en uso"
                       ]);   
               }
               return redirect()->route('user.edit', $user)->withErrors([
                   "email" => "Este email está en uso"
               ]);
            }
    
            $usuarios = User::select('username')->where('username', $request->username)->whereNot('id', $user->id)->get();
            if (count($usuarios) != 0) {
                if ($request->rol==null) { //Si es nulo significa que viene de actualizar el perfil desde la vista principal, no desde admin
                    return redirect()->route('user.edit')->withErrors([
                        "username" => "Este usuario está en uso"
                       ]);   
                }
                return redirect()->route('user.edit', $user)->withErrors([
                    "username" => "Este usuario está en uso"
                ]);
            }
    
            $user->nombre = $request->nombre;
            $user->apellidos = $request->apellidos;
            $user->username = $request->username;
    
            if ($request->password != null) { //Si el campo contraseña no se ha dejado vacío y desea cambiarla
                $request->validate([
                    "password" => "min:5|max:80"
                ]);
                $user->password =  Hash::make($request->password); //Codificamos la contraseña
            }
            $user->email = $request->email;
    
            if ($request->hasFile('avatar')) { //Si se desea moficiar el avatar
                if ($user->avatar != UserController::DEFAULT_AVATAR_URL) {
                    $avatarPublicId = $this->getPublicID($user->avatar);
                    Cloudinary::destroy($avatarPublicId); //Elimina la imagen de Cloudinary
                }
                $user->avatar = $this->uploadImage($request->avatar); //Subimos la nueva imagen
            }
    
            if ($request->rol!=null) { //Si es nulo significa que viene de actualizar el perfil desde la vista principal, no desde admin
                $user->rol = $request->rol;
            }
    
            $user->save();
            DB::commit();
    
            if ($request->rol==null) { 
                return redirect()->route('index');
            }
            return redirect()->route('admin.users')->with("message", "Usuario actualizado correctamente");
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
        }

    }

    public function deleteImageProfile(User $user){
        DB::beginTransaction();
        try {
            if ($user->avatar != UserController::DEFAULT_AVATAR_URL) {
                $publicID = $this->getPublicID($user->avatar);
                Cloudinary::destroy($publicID);
            }
            $user->avatar = UserController::DEFAULT_AVATAR_URL;
            $user->save();
            DB::commit();
            return redirect()->back()->with("message", "Imagen eliminada correctamente");
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
        }
    }

    public function updatePassword(Request $request){
        if (Hash::check($request->current_password, Auth::user()->password)) { //Si la contraseña actual es correcta
            $request->validate([ //Validación de campos
                "password" => "required|min:5|confirmed",
            ]);
            DB::beginTransaction();
            try {
                $user = User::find(Auth::user()->id);
                $user->password = Hash::make($request->password);
                $user->save();
                DB::commit();
                return redirect()->back()->with("message", "Contraseña actualizada correctamente");
            } catch (\Throwable $e) {
                DB::rollBack();
                return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
            }
        }
        else{
            return redirect()->back()->withErrors(["current_password"=>"Contraseña incorrecta"]);
        }
    }

    private function uploadImage($file){
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); //Obtengo el nombre de la img sin la extensión
        $imagePath = Cloudinary::upload($file->getRealPath(),[
            "public_id" => time() . "-" . $filename,
            "folder" => "books/avatars"
        ]);
        return $imagePath->getSecurePath();
    }

    private function getPublicID($url){ //Función que genera el public id de la imagen
        $parts = explode("/", $url);
        $filename = explode(".", array_pop($parts))[0];
        $parentPath = "books/avatars/";
        $publicID = urldecode($parentPath . $filename);
        return $publicID;
    }
}