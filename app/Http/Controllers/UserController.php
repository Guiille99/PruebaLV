<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Libro;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request){ //Listado de todos los usuarios
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
            "apellidos" => "required|min:2|max:80|",
            "email" => "required|unique:users",
            "username" => "required|min:5|max:25|unique:users",
            "password" => "required|min:5|max:80"
        ]);
        $user = new User();
        $user->nombre = $request->nombre;
        $user->apellidos = $request->apellidos;
        $user->username = $request->username;
        $user->password =  Hash::make($request->password); //Codificamos la contraseña
        $user->email = $request->email;
        $user->rol = $request->rol;

        $user->save();
        return redirect()->route('admin.users')->with("message", "Usuario añadido correctamente");
    }

    // public function destroy(User $user){ 
    public function destroy($id){ 
        $user=User::where('id', $id)->first();
        $user->delete(); //Elimina el usuario
        return redirect()->back()->with("message", "Usuario eliminado correctamente");
    }

    public function edit(User $user){ 
        return view("users.edit", compact('user'));
    }

    public function editPerfil(User $user){ 
        $generos=LibroController::getGeneros();
        return view("users.editPerfil", compact('user', 'generos'));
    }

    public function myData(User $user){
        $generos=LibroController::getGeneros();
        return view("users.editPerfil-datos", compact('user', 'generos'));
    }


    public function updatePerfil(Request $request, User $user){ 
        // dd($request);
        $request->validate([ //Validación de campos
            "nombre" => "required|min:2|max:80|",
            "apellidos" => "required|min:2|max:100|",
            "username" => "required|min:2|max:25|",
            "email" => "required|email|max:255",
        ]);

        if ($request->hasFile("avatar")) { //Si desea cambiar la imagen de perfil
            $request->validate([
                "avatar" => "image|mimes:jpeg,png|max:3000"
            ]);
            $file = $request->file("avatar");
            $destinationPath = "uploads/avatars/";//Se define la ruta donde se guardará el archivo subido
            $filename = time() . "-" . $file->GetClientOriginalName() ;//concatenamos el nombre del archivo con el tiempo en ms para que no se repita ningún archivo
            $uploadSuccess = $request->file('avatar')->move($destinationPath, $filename);//Movemos el archivo a la carpeta correspondiente
            $user->avatar = $destinationPath . $filename;//Subimos el archivo a la base de datos
        }

        $emails = User::all('email'); //Obtengo todos los emails

        foreach ($emails as $email) {
            if ($email->email==$request->email && $email->email!=$user->email) { //Si el email existe y no es el tuyo  
                return redirect()->route('user.editPerfil', $user)->withErrors([
                    "email" => "Este Email está en uso"
                ]);
            }
        }

        $usuarios = User::all('username');
        foreach ($usuarios as $usuario){
            if($usuario->username==$request->username && $usuario->username!=$user->username){
                return redirect()->route('user.editPerfil', $user)->withErrors([
                    "username" => "Este usuario está en uso"
                ]);
            }
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

        return redirect()->back()->with("message", "Usuario actualizado correctamente");
    }

    
    public function update(Request $request, User $user){ 
        // dd($request->rol);
        $request->validate([ //Validación de campos
            "nombre" => "required|min:2|max:80|",
            "apellidos" => "required|min:2|max:80|"
        ]);

        $emails = User::all('email'); //Obtengo todos los emails

        foreach ($emails as $email) {
            if ($email->email==$request->email && $email->email!=$user->email) { //Si el email existe y no es el tuyo
                if ($request->rol==null) { //Si es nulo significa que viene de actualizar el perfil desde la vista principal, no desde admin
                     return redirect()->route('user.edit')->withErrors([
                        "email" => "Este Email está en uso"
                        ]);   
                }
                return redirect()->route('user.edit', $user)->withErrors([
                    "email" => "Este Email está en uso"
                ]);
            }
        }

        $usuarios = User::all('username');
        foreach ($usuarios as $usuario){
            if($usuario->username==$request->username && $usuario->username!=$user->username){
                if ($request->rol==null) { //Si es nulo significa que viene de actualizar el perfil desde la vista principal, no desde admin
                    return redirect()->route('user.edit')->withErrors([
                        "username" => "Este usuario está en uso"
                       ]);   
                }
                return redirect()->route('user.edit', $user)->withErrors([
                    "username" => "Este usuario está en uso"
                ]);
            }
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

        if ($request->rol==null) { 
            return redirect()->route('index');
        }
        return redirect()->route('admin.users')->with("message", "Usuario actualizado correctamente");
    }
}
