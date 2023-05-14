<?php

namespace App\Http\Controllers;

use App\Charts\UsersChart;
use App\Charts\VentasChart;
use App\Models\Libro;
use App\Models\Pedido;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(){
        $chartData = $this->generaGrafica();
        $ingresoUltMes = $this->getIngresoUltMes();
        $beneficioUltMes = $this->getBeneficioUltimoMes();
        $librosVendidosUltMes = $this->getLibrosVendidosUltMes();
        $usuariosRegistrados = $this->getUsuariosRegistrados();
        $ventaChart = $chartData["ventaChart"];
        $userChart = $chartData["userChart"];
        
        return view('admin.dashboard', compact('ingresoUltMes', 'beneficioUltMes', 'librosVendidosUltMes', 'usuariosRegistrados', 'ventaChart', 'userChart'));
    }

    private function generaGrafica(){
        $monthName = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        $ventaChart = new VentasChart;
        $userChart = new UsersChart;
        $ventasPorMes = Pedido::selectRaw('MONTH(created_at) as mes, SUM(total) as total')->groupBy('mes')->get();
        $usuariosPorMes = User::selectRaw('MONTH(created_at) as mes, COUNT(id) as usuarios')->groupBy('mes')->get();
        foreach ($ventasPorMes as $ventaMes) {
            $meses[]= $monthName[$ventaMes->mes-1];
            $totales[]=$ventaMes->total;
        }
        foreach ($usuariosPorMes as $usuarioMes) {
            $mesesUser[]= $monthName[$usuarioMes->mes-1];
            $usuarios[]= $usuarioMes->usuarios;
        }
        //Gráfica de ventas
        $ventaChart->labels($meses);
        $ventaChart->dataset('Ventas', 'line', $totales)->options([
            'color' => "#219250",
            'backgroundColor' => '#219250',
            'borderColor' => '#219250',
            'responsive' => true
        ]);

        //Gráfica de usuarios
        $userChart->labels($mesesUser);
        $userChart->dataset('Usuarios por mes', 'line', $usuarios)->options([
            'color' => "#219250",
            'backgroundColor' => '#219250',
            'borderColor' => '#219250',
            'responsive' => true,
            'width' => '200px',
        ]);
        $data["ventaChart"] = $ventaChart;
        $data["userChart"] = $userChart;
        return $data;
    }

    private function getBeneficioUltimoMes(){
        $mesAnterior = Carbon::now()->subMonth()->month;
        $ingresosUltMes = Pedido::select(DB::raw('SUM(total) as ingreso'))->where(DB::raw('MONTH(created_at)'), '=', $mesAnterior)->first();
        $gastoUltMes = Libro::select(DB::raw('SUM(precio*0.6) as gasto'))->where(DB::raw('MONTH(created_at)'), '=', $mesAnterior)->first();
        $gastoUltMes = ($gastoUltMes->gasto==null) ? 0 : $gastoUltMes->gasto;
        $ingresosUltMes = ($ingresosUltMes->ingreso==null) ? 0 : $ingresosUltMes->ingreso;
        $beneficioUltMes = $ingresosUltMes - $gastoUltMes;
        return $beneficioUltMes;

    }

    private function getIngresoUltMes(){
        $ingresosUltMes = Pedido::select(DB::raw('SUM(total) as ingreso'))->where(DB::raw('MONTH(created_at)'), '=', Carbon::now()->subMonth()->month)->first();
        $ingresosUltMes = ($ingresosUltMes->ingreso==null) ? 0 : $ingresosUltMes->ingreso;
        return $ingresosUltMes;
    }

    private function getLibrosVendidosUltMes(){
        $pedidosUltMes = Pedido::where(DB::raw('MONTH(created_at)'), '=', 5)->get();
        $librosVendidosUltMes = 0;
        foreach ($pedidosUltMes as $pedido) {
            foreach ($pedido->libros as $libro) {
                $librosVendidosUltMes += $libro->pivot->cantidad;
            }
        } 
        return $librosVendidosUltMes;
    }
    private function getUsuariosRegistrados(){
        // $usuariosUltMes = User::select(DB::raw('COUNT(id) as usuarios'))->where(DB::raw('MONTH(created_at)'), '=', Carbon::now()->subMonth()->month)->first();
        $usuariosRegistrados = User::select(DB::raw('COUNT(id) as usuarios'))->first();
        $usuariosRegistrados = ($usuariosRegistrados->usuarios==null) ? 0 : $usuariosRegistrados->usuarios;
        return $usuariosRegistrados;
    }
}
