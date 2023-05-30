@extends('layouts.plantilla-admin')
@section('title', 'Books | Admin - Calendario')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js'></script>
@section('content')
<div class="tasks__container">
    <div id="calendar" class="my-4"></div>
    @livewire('task-list-component', ['tareas' => $tareasPendientesHoy])
</div>

<div class="modal fade" id="modal-tarea" tabindex="-1" aria-labelledby="tareaModal" aria-hidden="true">
    <div class="modal-dialog">
   
    <div class="modal-content">
        <div class="modal-header d-flex gap-2">
            <i class="bi bi-list-task"></i>
            <h1 class="modal-title fs-5" id="tareaModal"> Nueva tarea</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                {{-- <form id="modal-addTask-form" action="" method="post"> --}}
                    {{-- @csrf --}}
                    <div class="form-floating col">
                        <textarea id="tarea" class="form-control" placeholder="Tarea"></textarea>
                        <label for="tarea" class="form-label ms-1">Tarea</label>
                        @error('tarea')
                            <small class="text-danger">* {{$message}}</small> <br>
                        @enderror
                    </div>
                    <div class="form-floating mt-3 col">
                        <input type="date" id="fecInicio" class="form-control" placeholder="Fecha de inicio">
                        <label for="fecInicio" class="form-label ms-1">Fecha de inicio</label>
                        @error('fecInicio')
                            <small class="text-danger">* {{$message}}</small> <br>
                        @enderror
                    </div>
                    <div class="form-floating mt-3 col">
                        <input type="time" id="horaInicio" class="form-control" placeholder="Hora de inicio">
                        <label for="horaInicio" class="form-label ms-1">Hora de inicio</label>
                        @error('horaInicio')
                            <small class="text-danger">* {{$message}}</small> <br>
                        @enderror
                    </div>

                    <div class="form-floating mt-3 col">
                        <input type="date" id="fecFin" class="form-control" placeholder="Fecha de fin">
                        <label for="fecFin" class="form-label ms-1">Fecha de fin</label>
                        @error('fecFin')
                            <small class="text-danger">* {{$message}}</small> <br>
                        @enderror
                    </div>
                    <div class="form-floating mt-3 col">
                        <input type="time" id="horaFin" class="form-control" placeholder="Hora de fin">
                        <label for="horaFin" class="form-label ms-1">Hora de fin</label>
                        @error('horaFin')
                            <small class="text-danger">* {{$message}}</small> <br>
                        @enderror
                    </div>

                    <div class="mt-3 col">
                        <input type="checkbox" name="tarea_check" id="tarea_check" class="tarea_check d-none">
                        <label for="tarea_check" id="tarea_check-label" class="tarea_check-label">
                            <div class="task-list-mark">
                                <i class="bi bi-check"></i>
                            </div>
                            <span>Tarea realizada</span>
                        </label>

                    </div>

                    <div class="form-floating mt-3 col">
                        <input type="color" id="colorFondo" class="form-control" value="#2596be" placeholder="Color de fondo">
                        <label for="colorFondo" class="form-label ms-1">Color de fondo</label>
                        @error('colorFondo')
                            <small class="text-danger">* {{$message}}</small> <br>
                        @enderror
                    </div>

                    <div class="form-floating mt-3 col">
                        <input type="color" id="colorTexto" class="form-control" value="#111111" placeholder="Color de texto">
                        <label for="colorTexto" class="form-label ms-1">Color de texto</label>
                        @error('colorTexto')
                            <small class="text-danger">* {{$message}}</small> <br>
                        @enderror
                    </div>
                {{-- </form> --}}
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button id="btnDeleteTask" type="button" class="btn btn-danger text-white">Eliminar</button>
            <button id="btnAddTask" type="button" class="btn btn-success text-white">Confirmar</button>
            <button id="btnModifyTask" type="button" class="btn btn-success text-white">Modificar</button>
        </div>
    </div>  
    </div>
</div>

    
@endsection
@section('script')
    <script>
        let url = "{{route('tareas.get')}}";
        let addTaskURL = "{{route('tarea.store')}}";
        let modifyTaskURL = "{{route('tarea.update')}}";
        let deleteTaskURL = "{{route('tarea.destroy')}}";
    </script>
    @vite(["resources/js/calendar.js"])
@endsection