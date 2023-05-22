<?php

namespace App\Http\Controllers;

use App\Models\Provincia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProvinciaController extends Controller
{
    public function show(){
        return view('admin.provincias');
    }

    public function getProvincias(Request $request){
        if ($request->ajax()) {
            $provincias = Provincia::orderby('nombre')->get();
            return datatables()->of($provincias)
            ->addColumn('action', function($provincia){
                $btn="<div class='d-flex align-items-center justify-content-center gap-2'>
                <button type='button' id='btn-delete' data-id='$provincia->id' class='d-flex gap-2 btn-delete text-white btn-delete-user' title='Eliminar provincia' data-bs-toggle='modal' data-bs-target='#modal-delete' >
                    <i class='bi bi-trash3'></i> 
                </button>

                <a href='". route('edit.post', $provincia) ."' class='d-flex gap-2 btn-modify text-white' title='Editar provincia'>
                    <i class='bi bi-pencil-square'></i></a>
            </div>";
            return $btn;
            })
            ->toJson();
        }
        return redirect()->back();
    }

    public function create(){
        return view('provincias.create');
    }

    public function store(Request $request){
        $request->validate([
            "nombre" => "required|min:2|max:40|unique:provincias"
        ]);
        DB::beginTransaction();
        try {
            $provincia = new Provincia();
            $provincia->nombre = $request->nombre;
            $provincia->save();
            DB::commit();
            return redirect()->route('provincias.show')->with("message", "Provincia añadida correctamente");
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
        }
    }
}
