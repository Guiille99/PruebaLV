@extends('layouts.plantilla')
@section('title', 'Perfil')
@section('content')
<div class="container-fluid">
    <div class="form__modify__container col-12 col-md-6 col-lg-5 pt-4">
        <h1 class="title">Modificación de <strong>{{Auth::user()->nombre}}</strong></h1>
        <form action="{{route('user.updatePerfil', Auth::user())}}" method="post" class="needs-validation" novalidate>
            @csrf
            @method('put')
            <div class="container-fluid">
                <div class="row">
                    <div class="form-floating mt-3 col-md-6">
                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{Auth::user()->nombre}}" placeholder="Nombre" required>
                        <label for="nombre" class="form-label ms-1">Nombre</label>
                        <div class="invalid-feedback">
                            <small>Nombre obligatorio</small> 
                        </div>
                        @error('nombre')
                            <small class="text-danger">* {{$message}}</small> <br>
                        @enderror
                    </div>
            
                    <div class="form-floating mt-3 col-md-6">
                        <input type="text" name="apellidos" id="apellidos" class="form-control" value="{{Auth::user()->apellidos}}" placeholder="Apellidos" required>
                        <label for="apellidos" class="form-label ms-1">Apellidos</label>
                        <div class="invalid-feedback">
                            <small>Apellidos obligatorio</small> 
                        </div>
                        @error('apellidos')
                            <small class="text-danger">* {{$message}}</small> <br>
                        @enderror
                    </div>
            
                    <div class="form-floating mt-3 col-md-6">
                        <input type="text" name="username" id="username" class="form-control" value="{{Auth::user()->username}}" placeholder="Usuario" required>
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
                        <input type="email" name="email" id="email" class="form-control" value="{{Auth::user()->email}}" placeholder="Email" required>
                        <label for="email" class="form-label ms-1">Email</label>
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