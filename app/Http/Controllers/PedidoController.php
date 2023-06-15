<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use App\Models\Pedido;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function showPedidos(){
        $user = User::find(Auth::user()->id);
        $pedidos = $user->pedidos()->orderby('created_at', 'desc')->paginate(5);
        return view('pedidos.mis-pedidos', compact('user', 'pedidos'));
    }

    public function showAllOrders(){
        return view("admin.orders");
    }

    public function edit(Pedido $pedido){
        $estados = Estado::all();
        $libros = $pedido->libros;
        $collection = collect($libros);

        //Paginar una colección de datos
        $perPage = 5;
        $page = request()->get('page', 1);
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $collection->forPage($page, $perPage),
            $collection->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        return view("pedidos.edit", ["libros" => $paginator] , compact('pedido', 'estados'));
    }

    public function update(Request $request, Pedido $pedido){
        DB::beginTransaction();
        try {
            $pedido->estado = $request->estado;
            $pedido->save();
            DB::commit();
            return redirect()->route('admin.index')->with("message", "Estado actualizado correctamente");
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
        }
    }

    public function getUltimosPedidos(Request $request){
        if ($request->ajax()) {
            $pedidos = Pedido::orderby('id', 'desc')->get();
            return datatables()->of($pedidos)
            ->addColumn('user_id', function($pedido){
                return $pedido->user->username;
            })
            ->addColumn('action', function($pedido){
                $btn="<div class='d-flex align-items-center justify-content-center gap-2'>
                <button type='button' id='btn-delete' data-id='$pedido->id' class='d-flex gap-2 btn-delete text-white btn-delete-user' title='Eliminar pedido' data-bs-toggle='modal' data-bs-target='#modal-delete' >
                    <i class='bi bi-trash3'></i> 
                </button>

                <a href='". route('edit.order', $pedido) ."' class='d-flex gap-2 btn-modify text-white' title='Editar pedido'>
                    <i class='bi bi-pencil-square'></i></a>
            </div>";
            return $btn;
            })
            ->toJson();
        }
        return redirect()->back();
    }

    public function showPedidosCancelados(){
        $user = User::find(Auth::user()->id);
        $pedidos = $user->pedidos()->where('estado', 'Cancelado')->orderby('created_at', 'desc')->paginate(5);
        return view('pedidos.pedidos-cancelados', compact('user', 'pedidos'));
    }

    public function cancelaPedido($idPedido){
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

    public function destroy(Pedido $pedido){
        DB::beginTransaction();
        try {
            $pedido->delete();
            DB::commit();
            return redirect()->route('admin.index')->with("message", "El pedido ha sido eliminado correctamente");
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with("message_error", "Ha ocurrido un error inesperado");
        }
    }

    public static function getLastNPedidos(Request $request){
        if ($request->ajax()) {
            $pedidos = Pedido::orderby('id', 'desc')->take(5);
            return datatables()->of($pedidos)
            ->addColumn('user_id', function($pedido){
                return $pedido->user->username;
            })
            ->addColumn('action', function($pedido){
                $btn="<div class='d-flex align-items-center justify-content-center gap-2'>
                <button type='button' id='btn-delete' data-id='$pedido->id' class='d-flex gap-2 btn-delete text-white btn-delete-user' title='Eliminar pedido' data-bs-toggle='modal' data-bs-target='#modal-delete' >
                    <i class='bi bi-trash3'></i> 
                </button>

                <a href='". route('edit.order', $pedido) ."' class='d-flex gap-2 btn-modify text-white' title='Editar pedido'>
                    <i class='bi bi-pencil-square'></i></a>
            </div>";
            return $btn;
            })
            ->toJson();
        }
        return redirect()->back();
    }
}
