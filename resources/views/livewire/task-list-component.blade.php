<div class="tasklist__container">
    <div class="header">
        <h5>Tareas pendientes para hoy</h5>
    </div>
    {{-- {{count($tareas)}} --}}
    <div class="tasks">
        @if (count($tareas) == 0)
            <p class="text-center">No hay tareas pendientes para hoy</p>
        @else
        @foreach ($tareas as $tarea)
            <div class="task">
                <input type="checkbox" wire:model="selectedTasks" name="tarea_check" id="task-{{$tarea->id}}" class="d-none tarea_check" value="{{$tarea->id}}" wire:ignore>
                <label for="task-{{$tarea->id}}" class="tarea_check-label">
                    <div class="task-list-mark" wire:ignore>
                        <i class="bi bi-check"></i>
                    </div>
                </label>
                <div class="task__info">
                    <p class="title" wire:ignore>{{$tarea->titulo}}</p>
                    <div class="task__info-date">
                        <i class="bi bi-calendar"></i>
                        <span class="date">{{$tarea->fin}}</span>
                    </div>
                </div>
            </div>
        @endforeach
        @endif
    </div>
    @if (count($tareas) != 0)
        <div class="buttons__container">
            <button wire:click="updateEstado" wire:ignore class="btn-modify m-auto">Modificar</button>
        </div>
    @endif
</div>
