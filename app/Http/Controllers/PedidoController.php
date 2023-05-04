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
