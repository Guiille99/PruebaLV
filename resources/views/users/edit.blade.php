@extends('layouts.plantilla-admin')
@section('title', 'Modificación de usuario')
@section('content')
<div class="form__modify__container col-12 col-md-6 col-lg-5 pt-4">
    <h1 class="title">Modificación de {{$user->username}}</h1>
    <form action="{{route('user.update', $user)}}" method="post" class="needs-validation" novalidate>
        @csrf
        @method('put')
        <div class="container-fluid">
            <div class="row">
                <div class="form-floating mt-3 col-md-6">
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{$user->nombre}}" placeholder="Nombre" required>
                    <label for="nombre" class="form-label ms-1">Nombre</label>
                    <div class="invalid-feedback">
                        <small>Nombre obligatorio</small> 
                    </div>
                    @error('nombre')
                        <small class="text-danger">* {{$message}}</small> <br>
                    @enderror
                </div>
        
                <div class="form-floating mt-3 col-md-6">
                    <input type="text" name="apellidos" id="apellidos" class="form-control" value="{{$user->apellidos}}" placeholder="Apellidos" required>
                    <label for="apellidos" class="form-label ms-1">Apellidos</label>
                    <div class="invalid-feedback">
                        <small>Apellidos obligatorio</small> 
                    </div>
                    @error('apellidos')
                        <small class="text-danger">* {{$message}}</small> <br>
                    @enderror
                </div>
        
                <div class="form-floating mt-3 col-md-6">
                    <input type="text" name="username" id="username" class="form-control" value="{{$user->username}}" placeholder="Usuario" required>
                    <label for="username" class="form-label ms-1">Usuario</label>
                    <div class="invalid-feedback">
                        <small>Usuario obligatorio</small> 
                    </div>
                    @error('username')
                        <small class="text-danger">* {{$message}}</small> <br>
                    @enderror
                </div>


                <div class="form-floating mt-3 col-md-6">
                    <input type="password" name="password" id="password" class="form-control" value="" placeholder="Contraseña">
                    <i id="togglePassword" class="bi bi-eye"></i>
                    <label for="password" class="form-label ms-1">Contraseña</label>
                    <div class="invalid-feedback">
                        <small>Contraseña obligatoria</small> 
                    </div>
                    @error('password')
                        <small class="text-danger">* {{$message}}</small> <br>
                    @enderror
                </div>

                <div class="form-floating mt-3">
                    <input type="email" name="email" id="email" class="form-control" value="{{$user->email}}" placeholder="Email" required>
                    <label for="email" class="form-label ms-1">Email</label>
                    <div class="invalid-feedback">
                        <small>Email inválido</small> 
                    </div>
                    @error('email')
                        <small class="text-danger">* {{$message}}</small> <br>
                    @enderror
                </div>

                <div class="mt-3">
                    <select name="rol" id="rol" class="form-select" aria-label="rol" required>
                        <option value="">-- Selecciona un rol --</option>
                        @if ($user->rol=="Usuario")
                            <option value="Usuario" selected>Usuario</option>
                        @else
                            <option value="Usuario">Usuario</option>
                        @endif

                        @if ($user->rol=="Administrador")
                            <option value="Administrador" selected>Aministrador</option>
                            
                        @else
                            <option value="Administrador">Aministrador</option>
                        @endif
                    </select>
                </div>
        
        
                <div class="mt-4">
                    <input type="submit" value="Modificar" class="btn-modify">
                </div>
    
            </div>
        </div>

    </form>
</div>
@endsection