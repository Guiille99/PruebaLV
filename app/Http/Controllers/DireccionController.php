<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Direccion;
use App\Models\Provincia;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DireccionController extends Controller
{

    public function create(){
        $provincias = Provincia::all();
        return view('direcciones.create', compact('provincias'));
    }

    public function store(Request $request){
        $request->validate([ //Validación de campos
            "calle" => "required|min:2|max:50|",
            "num" => "required|numeric|max:999|",
            "provincia" => "required",
            "cp" => "required|min:5|max:6",
        ]);
        $user = User::find(Auth::user()->id);
        if ($user->direcciones()->count()<3) {
            DB::beginTransaction();
            try {
                $direccion = new Direccion();
                $direccion->cp = $request->cp;
                $direccion->calle = $request->calle;
                $direccion->numero = $request->num;
                $direccion->provincia_id = $request->provincia;
                $direccion->save();
                DB::commit();
               
                if ($user->direcciones()->wherePivot('principal', '1')->count()==0) { //Si no tiene una dirección principal
                    $user->direcciones()->attach($direccion->id, ["principal"=>1]);
                }
                else if ($request->has("principal")) { //Si quiere que la nueva dirección sea la principal
                    $old_principal = $user->direcciones()->wherePivot('principal', '1')->first();
                    $user->direcciones()->updateExistingPivot($old_principal->id, ["principal"=> 0]);
                    $user->direcciones()->attach($direccion->id, ["principal"=>1]);
                }
                else{
                    $user->direcciones()->attach($direccion->id, ["principal"=>0]);
                }
                    
                DB::commit();
                return redirect()->route('user.editPerfil-direcciones', $user)->with("message", "Dirección agregada correctamente");
            } catch (\Throwable $e) {
                DB::rollBack();
                return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
            }
        }
        else{
            return redirect()->route('user.editPerfil-direcciones', $user);
        }
    }

    public function edit(User $user, Direccion $direccion){
        $provincias = Provincia::all();
        return view('direcciones.edit', compact('provincias', 'user', 'direccion'));
    }

    public function update(Request $request, Direccion $direccion){
        $request->validate([ //Validación de campos
            "calle" => "required|min:2|max:50|",
            "num" => "required|numeric|max:999|",
            "provincia" => "required",
            "cp" => "required|min:5|max:6",
        ]);

        DB::beginTransaction();
        try {
            $direccion->calle = $request->calle;
            $direccion->numero = $request->num;
            $direccion->provincia_id = $request->provincia;
            $direccion->cp = $request->cp;
            $direccion->save();
            DB::commit();
            return redirect()->back()->with("message", "Dirección actualizada correctamente");
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
        }
    }

    public function updatePrincipalAddress(Request $request, User $user){
        DB::beginTransaction();
        try {
            $old_principal = $user->direcciones()->wherePivot('principal', '1')->first();
            $user->direcciones()->updateExistingPivot($old_principal->id, ["principal"=> 0]);
            $user->direcciones()->updateExistingPivot($request->principalAddress, ["principal"=> 1]);
            DB::commit();
            return redirect()->back()->with("message", "La dirección principal ha sido modificada correctamente");
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
        }
    }

    public function destroy(User $user, Direccion $direccion){
        DB::beginTransaction();
        try {
            $direccion->delete();
            if ($user->direcciones()->count()>0) {
                if ($user->direcciones()->wherePivot('principal', '1')->count() == 0) { //Si el usuario no tiene dirección principal
                    $user->direcciones()->updateExistingPivot($user->direcciones()->first()->id, ["principal"=> 1]);
                }
            }
            DB::commit();
            return redirect()->back()->with("message", "Dirección eliminada correctamente");
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
        }
    }

    public static function checkDireccionPrincipal($direcciones) { //Función que comprueba si el usuario tiene alguna dirección principal
        foreach ($direcciones as $direccion) {
            if ($direccion->pivot->principal == 1) {
                return true;
            }
        }
        return false;   
    }

}
