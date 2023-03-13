@extends('layouts.plantilla-admin')
@section('title', 'Books | Admin')
@section('content')
{{-- {{$libros}} --}}
       {{-- DATOS --}}
       <div id="registros__container" class="col col-lg-10 pt-3">
        <div class="registros row">
            <div class="col">
                <div class="header__container">
                    <h3 class="title text-center">Lista de Libros</h3>
                    <a href="{{route('libro.create')}}" class="btn-add"> <i class="bi bi-plus"></i> Nuevo libro</a>
                </div>
                <div class="table-responsive">
                    <table class="table text-center table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Autor</th>
                                <th>Editorial</th>
                                {{-- <th>ISBN</th> --}}
                                <th>Stock</th>
                                <th>Fecha Publicación</th>
                                <th>Precio</th>
                                <th>Género</th>
                                <th>Valoración</th>
                                <th>Fecha creación</th>
                                <th>Fecha modificación</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($libros as $libro)
                                <tr>
                                    <td>{{$libro->id}}</td>
                                    <td>{{$libro->titulo}}</td>
                                    <td>{{$libro->autor}}</td>
                                    <td>{{$libro->editorial}}</td>
                                    {{-- <td>{{$libro->isbn}}</td> --}}
                                    <td>{{$libro->stock}}</td>
                                    <td>{{$libro->fecha_publicacion}}</td>
                                    <td>{{$libro->precio}}€</td>
                                    <td>{{$libro->genero}}</td>
                                    <td>{{$libro->valoracion}}</td>
                                    <td>{{$libro->created_at}}</td>
                                    <td>{{$libro->updated_at}}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <button type="button" class="d-flex gap-2 btn-delete text-white" data-bs-toggle="modal" data-bs-target="#modal-delete-{{$libro->id}}" >
                                                <i class="bi bi-trash3"></i> Eliminar
                                            </button>

                                            <a href="{{route('libro.edit', $libro)}}" class="d-flex gap-2 btn-modify text-white">
                                                <i class="bi bi-pencil-square"></i> Modificar</a>
                                        </div>
                                    </td>
                                </tr>
    
                                @include('admin.deleteLibro') {{-- Añado el modal de confirmación para el borrado de registros --}}
                            @endforeach
                            </tbody>
                    </table>

                </div>

                <div class="w-100">
                    {{$libros->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection