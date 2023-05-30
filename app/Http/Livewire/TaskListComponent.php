<?php

namespace App\Http\Livewire;

use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TaskListComponent extends Component
{

    public $tareas;
    public $selectedTasks = [];

    public function mount($tareas){
        $this->tareas = $tareas;
    }

    public function updateEstado(){
        DB::beginTransaction();
        try {
            foreach ($this->tareas as $tarea) {
                (in_array($tarea->id, $this->selectedTasks)) ? $tarea->is_finish = 1 : $tarea->is_finish = 0;
                $tarea->save();
            }
            DB::commit();
            $this->dispatchBrowserEvent('alert-admin-live-success', ['message' => 'Tarea modificada correctamente']);
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->dispatchBrowserEvent('alert-admin-live-error', ['message' => 'Ha ocurrido un error inesperado']);
        }
    }

    public function render(){
        $this->tareas = Tarea::where('user_id', Auth::id())->whereDate('fin', today())->where('is_finish', 0)->get();
        return view('livewire.task-list-component');
    }
}
