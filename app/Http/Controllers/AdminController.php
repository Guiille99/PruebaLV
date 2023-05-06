<?php

namespace App\Http\Controllers;

use App\Charts\UsersChart;
use App\Charts\VentasChart;
use App\Models\Pedido;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $monthName = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        $chart = new VentasChart;
        $userChart = new UsersChart;
        $ventasPorMes = Pedido::selectRaw('MONTH(created_at) as mes, SUM(total) as total')->groupBy('mes')->get();
        $usuariosPorMes = User::selectRaw('MONTH(created_at) as mes, COUNT(id) as usuarios')->groupBy('mes')->get();
        $totales=[];
        $meses=[];
        foreach ($ventasPorMes as $ventaMes) {
            $meses[]= $monthName[$ventaMes->mes-1];
            $totales[]=$ventaMes->total;
        }
        foreach ($usuariosPorMes as $usuarioMes) {
            $mesesUser[]= $monthName[$usuarioMes->mes-1];
            $usuarios[]= $usuarioMes->usuarios;
        }
        // dd($usuariosPorMes);
        //Gráfica de ventas
        $chart->labels($meses);
        $chart->dataset('Ventas', 'line', $totales)->options([
            'color' => "#219250",
            'backgroundColor' => '#219250',
            'borderColor' => '#219250',
            'responsive' => true
        ]);

        // dump($mesesUser);
        // dd($usuarios);
        //Gráfica de usuarios
        $userChart->labels($mesesUser);
        $userChart->dataset('Usuarios por mes', 'line', $usuarios)->options([
            'color' => "#219250",
            'backgroundColor' => '#219250',
            'borderColor' => '#219250',
            'responsive' => true,
            'width' => '200px',
        ]);
        return view('admin.dashboard', compact('chart', 'userChart'));
    }
}
