<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function showPedidos(){
        $generos = LibroController::getGeneros();
        $user = User::find(Auth::user()->id);
        $pedidos = $user->pedidos()->orderby('created_at', 'desc')->paginate(5);
        return view('pedidos.mis-pedidos', compact('generos', 'user', 'pedidos'));
    }

    public function getUltimosPedidos(Request $request){
        if ($request->ajax()) {
            $pedidos = Pedido::orderby('id', 'desc')->get();
            return datatables()->of($pedidos)
            ->addColumn('user_id', function($pedido){
                return $pedido->user->username;
            })
            ->addColumn('direccion_id', function($pedido){
                return $pedido->direccion->calle . ", " . $pedido->direccion->numero . " - " . $pedido->direccion->cp ." (" . $pedido->direccion->provincia->nombre . ")";
            })
            ->addColumn('action', function($pedido){
                $btn="<div class='d-flex align-items-center justify-content-center gap-2'>
                <button type='button' id='btn-delete' data-id='$pedido->id' class='d-flex gap-2 btn-delete text-white btn-delete-user' title='Eliminar pedido' data-bs-toggle='modal' data-bs-target='#modal-delete' >
                    <i class='bi bi-trash3'></i> 
                </button>

                <a href='' class='d-flex gap-2 btn-modify text-white' title='Editar pedido'>
                    <i class='bi bi-pencil-square'></i></a>
            </div>";
            return $btn;
            })
            ->toJson();
        }
        return redirect()->back();
    }

    public function showPedidosCancelados(){
        $generos = LibroController::getGeneros();
        $user = User::find(Auth::user()->id);
        $pedidos = $user->pedidos()->where('estado', 'Cancelado')->orderby('created_at', 'desc')->paginate(5);
        return view('pedidos.pedidos-cancelados', compact('generos', 'user', 'pedidos'));
    }

    public function cancelaPedido($idPedido){
        // dd($idPedido);
        $pedido = Pedido::find($idPedido);
        DB::beginTransaction();
        try {
            $pedido->estado = "Cancelado";
            $pedido->save();
            DB::commit();
            return redirect()->back()->with("message", "El pedido ha sido cancelado correctamente");
        } catch (\Throwable $e) {
            return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
        }
    }
}
