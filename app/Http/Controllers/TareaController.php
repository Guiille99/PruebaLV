<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TareaController extends Controller
{

    public function showCalendar(){
        $tareasPendientesHoy = Tarea::where('user_id', Auth::id())->whereDate('fin', today())->where('is_finish', 0)->get();
        return view('admin.calendar', compact('tareasPendientesHoy'));
    }

    public function store(Request $request){
        DB::beginTransaction();
        try {
            $fechaInicioAux = $request->fechaInicio . " ". $request->horaInicio;
            $fechaFinAux = $request->fechaFin . " ". $request->horaFin;
            $fechaInicio = $this->compruebaFechas($fechaInicioAux, $fechaFinAux)["fechaInicio"];
            $fechaFin = $this->compruebaFechas($fechaInicioAux, $fechaFinAux)["fechaFin"];
            
            $tarea = new Tarea();
            $tarea->user_id = Auth::id();
            $tarea->titulo = $request->tarea;
            $tarea->inicio = $fechaInicio;

            $tarea->fin = $fechaFin;
            $tarea->color_texto = $request->colorTexto;
            $tarea->color_fondo = $request->colorFondo;

            $tarea->save();
            DB::commit();
            return response()->json("{'message': 'Tarea añadida correctamente'}");
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json("{'message': $e}");
        }
    }

    public function update(Request $request){
        DB::beginTransaction();
        try {
            $fechaInicioAux = $request->fechaInicio . " ". $request->horaInicio;
            $fechaFinAux = $request->fechaFin . " ". $request->horaFin;
            $fechaInicio = $this->compruebaFechas($fechaInicioAux, $fechaFinAux)["fechaInicio"];
            $fechaFin = $this->compruebaFechas($fechaInicioAux, $fechaFinAux)["fechaFin"];

            $tarea = Tarea::find($request->id);
            $tarea->titulo = $request->tarea;
            $tarea->inicio = $fechaInicio;
            $tarea->fin = $fechaFin;
            $tarea->color_texto = $request->colorTexto;
            $tarea->color_fondo = $request->colorFondo;
            ($request->tareaRealizada == "true") ? $tarea->is_finish = 1 : $tarea->is_finish = 0;
            $tarea->save();
            DB::commit();
            return response()->json("{'message': 'La tarea se ha modificado correctamente'}");
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json("{'message': 'Ha ocurrido un error inesperado'}");
        }
    }


    public function destroy(Request $request){
        DB::beginTransaction();
        try {
            $tarea = Tarea::find($request->id);
            $tarea = $tarea->delete();
            DB::commit();
            return response()->json("{'message': 'La tarea se ha eliminado correctamente'}");
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json("{'message': 'Ha ocurrido un error inesperado'}");
        }
    }

    public function getTareas(){
        $tareas = Auth::user()->tareas;
        foreach ($tareas as $tarea) {
            $events[] = [
                "id" => $tarea->id,
                "title" => $tarea->titulo,
                "start" => $tarea->inicio,
                "end" => $tarea->fin,
                "status" => $tarea->is_finish,
                "textColor" => $tarea->color_texto,
                "backgroundColor" => $tarea->color_fondo
            ];
        }

        return response()->json($events);
    }

    private function compruebaFechas($fechaInicio, $fechaFin){
        $fechaInicioTimestamp = strtotime($fechaInicio);
        $fechaFinTimestamp = strtotime($fechaFin);

        if ($fechaInicioTimestamp > $fechaFinTimestamp) {
            $fechaFinTimestamp = $fechaInicioTimestamp;
        }

        $fechaInicio = date("Y-m-d H:i", $fechaInicioTimestamp);
        $fechaFin = date("Y-m-d H:i", $fechaFinTimestamp);

        return ["fechaInicio" => $fechaInicio, "fechaFin" => $fechaFin];
    }
}
