@extends('layouts.plantilla-admin')
@section('title', 'Books | Admin')
@section('content')
{{-- {{$users}} --}}
{{-- @if (Session::has('userUpdate'))
    <p class="text-danger">{{Session::get('userUpdate')}}</p>
@endif --}}
    {{-- DATOS --}}
    <div id="registros__container" class="col col-lg-10 pt-3">
        <div class="registros row">
            <div class="col">
                <div class="header__container">
                    <h3 class="title text-center">Lista de Usuarios</h3>
                    <a href="{{route('user.create')}}" class="btn-add"> <i class="bi bi-plus"></i> Nuevo usuario</a>
                </div>
                <div class="table-responsive">
                    <table class="table text-center table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Fecha creación</th>
                                <th>Última modificación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{$user->id}}</td>
                                    <td>{{$user->nombre}}</td>
                                    <td>{{$user->apellidos}}</td>
                                    <td>{{$user->username}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->rol}}</td>
                                    <td>{{$user->created_at}}</td>
                                    <td>{{$user->updated_at}}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <button type="button" class="d-flex gap-2 btn-delete text-white" data-bs-toggle="modal" data-bs-target="#modal-delete-{{$user->id}}" >
                                                <i class="bi bi-trash3"></i> Eliminar
                                            </button>

                                            <a href="{{route('user.edit', $user)}}" class="d-flex gap-2 btn-modify text-white">
                                                <i class="bi bi-pencil-square"></i> Modificar</a>
                                        </div>
                                    </td>
                                </tr>
    
                                @include('admin.delete') {{-- Añado el modal de confirmación para el borrado de registros --}}
                            @endforeach
                            </tbody>
                    </table>

                </div>

                <div class="w-100">
                    {{$users->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection