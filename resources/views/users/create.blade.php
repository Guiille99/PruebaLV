@extends('layouts.plantilla-admin')
@section('title', 'Creación de usuario')
@section('content')
<div class="form__modify__container col-12 col-md-6 col-lg-5 pt-4">
    <h1 class="title">Creación de nuevo usuario</h1>
    <form action="{{route('user.store')}}" method="post" class="needs-validation" novalidate>
        @csrf
        <div class="container-fluid">
            <div class="row">
                {{-- Nombre --}}
                <div class="form-floating mt-3 col-md-6">
                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" required>
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
                    <input type="text" name="apellidos" id="apellidos" class="form-control" placeholder="Apellidos" required>
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
                    <input type="text" name="username" id="username" class="form-control" placeholder="Usuario" required>
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
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                    <label for="email" class="form-label ms-1">Email</label>
                    <div class="invalid-feedback">
                        <small>Email inválido</small> 
                    </div>
                    @error('email')
                    <small class="text-danger">* {{$message}}</small> <br>
                @enderror
                </div>

                {{-- Rol --}}
                <div class="mt-3">
                    <select name="rol" id="rol" class="form-select" aria-label="rol" required>
                        <option value="">-- Selecciona un rol --</option>
                        <option value="Usuario">Usuario</option>
                        <option value="Administrador">Aministrador</option>
                    </select>
                </div>
          
        
                <div class="mt-4">
                    <input type="submit" value="Crear usuario" class="btn-add">
                </div>
    
            </div>
        </div>

    </form>
</div>
@endsection