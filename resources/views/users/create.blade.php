@extends('layouts.plantilla-admin')
@section('title', 'Books | Creación de usuario')
@section('content')
<div class="form__modify__container register__section pt-4">
    <div class="title">
        <p>Creación de nuevo usuario</p>
    </div>
    <form action="{{route('user.store')}}" method="post" class="needs-validation" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="container-fluid">
            <div class="row">
                {{-- Nombre --}}
                <div class="form-floating mt-3 col-md-6">
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{old('nombre')}}" placeholder="Nombre" required>
                    <label for="nombre" class="form-label ms-1">Nombre</label>
                    <div class="invalid-feedback">
                        <small>Nombre obligatorio</small> 
                    </div>
                    @error('nombre')
                        <small class="text-danger">* {{$message}}</small> <br>
                    @enderror
                </div>
        
                {{-- Apellidos --}}
                <div class="form-floating mt-3 col-md-6">
                    <input type="text" name="apellidos" id="apellidos" class="form-control" value="{{old('apellidos')}}" placeholder="Apellidos" required>
                    <label for="apellidos" class="form-label ms-1">Apellidos</label>
                    <div class="invalid-feedback">
                        <small>Apellidos obligatorios</small> 
                    </div>
                    @error('apellidos')
                        <small class="text-danger">* {{$message}}</small> <br>
                    @enderror
                </div>
        
                {{-- Usuario --}}
                <div class="form-floating mt-3 col-md-6">
                    <input type="text" name="username" id="username" class="form-control" value="{{old('username')}}" placeholder="Usuario" required>
                    <label for="username" class="form-label ms-1">Usuario</label>
                    <div class="invalid-feedback">
                        <small>Usuario obligatorio</small> 
                    </div>
                    @error('username')
                        <small class="text-danger">* {{$message}}</small> <br>
                    @enderror
                </div>

                {{-- Contraseña --}}
                <div class="form-floating mt-3 col-md-6">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" required>
                    <i id="togglePassword" class="bi bi-eye"></i>
                    <label for="password" class="form-label ms-1">Contraseña</label>
                    <div class="invalid-feedback">
                        <small>Contraseña obligatoria</small> 
                    </div>
                    @error('password')
                        <small class="text-danger">* {{$message}}</small> <br>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-floating mt-3">
                    <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}" placeholder="Email" required>
                    <label for="email" class="form-label ms-1">Email</label>
                    <div class="invalid-feedback">
                        <small>Email inválido</small> 
                    </div>
                    @error('email')
                    <small class="text-danger">* {{$message}}</small> <br>
                @enderror
                </div>

                {{-- Avatar --}}
                <div class="form-floating mt-3 col-md-6">
                    <input type="file" name="avatar" id="avatar" class="form-control" placeholder="Imagen de perfil">
                    <label for="avatar" class="form-label ms-1">Imagen de perfil</label>
                    @error('avatar')
                        <small class="text-danger">* {{$message}}</small>
                    @enderror
                </div>

                {{-- Rol --}}
                <div class="mt-3 col-md-6">
                    <select name="rol" id="rol" class="form-select h-100" aria-label="rol" required>
                        <option value="">-- Selecciona un rol --</option>
                        <option value="Usuario">Usuario</option>
                        <option value="Administrador">Aministrador</option>
                    </select>
                </div>
          
        
                <div class="buttons__container mt-4">
                    <input type="submit" value="Crear usuario" class="btn-add">
                    <a href="{{route('admin.users')}}" class="btn-back">Volver</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection