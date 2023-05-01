@extends('layouts.plantilla-editPerfil')
@section('content-profile')
@section('miCuenta-isActive', 'active')
    <div class="column account__details profile-section my-data__container">
        <div class="title">
            <p>MIS DATOS</p>
            <p class="require-data-message">* Dato obligatorio</p>
        </div>

        <div class="data">
            <form enctype="multipart/form-data" action="{{route('user.updatePerfil', $user)}}" method="post">
                @csrf
                @method('put')
                <div class="container-fluid">
                    <div class="row">
                        <div class="form-floating mt-3 col-md-6">
                            <input type="text" name="nombre" id="nombre" class="form-control" value="{{$user->nombre}}" placeholder="Nombre" required>
                            <label for="nombre" class="form-label ms-1">* Nombre</label>
                            <div class="invalid-feedback">
                                <small>Nombre obligatorio</small> 
                            </div>
                            @error('nombre')
                                <small class="text-danger">* {{$message}}</small> <br>
                            @enderror
                        </div>
                
                        <div class="form-floating mt-3 col-md-6">
                            <input type="text" name="apellidos" id="apellidos" class="form-control" value="{{$user->apellidos}}" placeholder="Apellidos" required>
                            <label for="apellidos" class="form-label ms-1">* Apellidos</label>
                            <div class="invalid-feedback">
                                <small>Apellidos obligatorio</small> 
                            </div>
                            @error('apellidos')
                                <small class="text-danger">* {{$message}}</small> <br>
                            @enderror
                        </div>
                
                        <div class="form-floating mt-3 col-md-6">
                            <input type="text" name="username" id="username" class="form-control" value="{{$user->username}}" placeholder="Usuario" required>
                            <label for="username" class="form-label ms-1">* Usuario</label>
                            <div class="invalid-feedback">
                                <small>Usuario obligatorio</small> 
                            </div>
                            @error('username')
                                <small class="text-danger">* {{$message}}</small> <br>
                            @enderror
                        </div>

                        <div class="form-floating mt-3 col-md-6">
                            <input type="file" name="avatar" id="avatar" class="form-control">
                            <label for="avatar" class="form-label ms-1">Imagen de perfil</label>
                            @error('avatar')
                                <small class="text-danger">* {{$message}}</small> <br>
                            @enderror
                        </div>

                        <div class="form-floating mt-3">
                            <input type="email" name="email" id="email" class="form-control" value="{{$user->email}}" placeholder="Email" required>
                            <label for="email" class="form-label ms-1">* Email</label>
                            <div class="invalid-feedback">
                                <small>Email inválido</small> 
                            </div>
                            @error('email')
                                <small class="text-danger">* {{$message}}</small> <br>
                            @enderror
                        </div>                
                
                        <div class="mt-4">
                            <input type="submit" value="Modificar" class="btn-modify">
                        </div>
            
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection