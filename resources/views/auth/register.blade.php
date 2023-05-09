@extends('layouts.plantillalogin')
@section('title', "Registro")

@section('content')
<div class="container-fluid vh-100 form__hero" style="background-image: url({{asset('uploads/bookshop.jpg')}})">

    <div class="row flex-column gap-2 justify-content-center align-items-center h-100">
        <figure class="w-auto">
            <a href="{{route('index')}}">
                <img src="uploads/logo-nombre2.svg" alt="Logo">
            </a>
        </figure>

        <div class="col-10 col-md-8 col-lg-4 login">
            <h2 class="login__title">REGISTRO</h2>

            <form action="{{route("register.store")}}" method="post" class="needs-validation" novalidate>
                @csrf
                <div class="form-floating mt-3">
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{old('nombre')}}" placeholder="Nombre" required>
                    <label for="nombre" class="form-label">Nombre</label>
                    <div class="invalid-feedback">
                        <small>Nombre obligatorio</small> 
                    </div>
                </div>
                @error('nombre')
                    <small class="text-danger">* {{$message}}</small> <br>
                @enderror

                <div class="form-floating mt-3">
                    <input type="text" name="apellidos" id="apellidos" class="form-control" value="{{old('apellidos')}}" placeholder="Apellidos" required>
                    <label for="apellidos" class="form-label">Apellidos</label>
                    <div class="invalid-feedback">
                        <small>Apellidos obligatorio</small> 
                    </div>
                </div>
                @error('apellidos')
                    <small class="text-danger">* {{$message}}</small> <br>
                @enderror

                <div class="form-floating mt-3">
                    <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}" placeholder="Email" required>
                    <label for="email" class="form-label">Email</label>
                    <div class="invalid-feedback">
                        <small>Formato de email inválido</small> 
                    </div>
                </div>
                @error('email')
                    <small class="text-danger">* {{$message}}</small> <br>
                @enderror

                <div class="form-floating mt-4">
                    <input type="text" name="username" id="username" class="form-control" value="{{old('username')}}" placeholder="Usuario" required>
                    <label for="username" class="form-label">Usuario</label>
                    <div class="invalid-feedback">
                        <small>Usuario obligatorio</small> 
                    </div>
                </div>
                @error('username')
                    <small class="text-danger">* {{$message}}</small> <br>
                @enderror

                <div class="form-floating mt-3">
                    <input type="password" name="password" id="password" class="form-control" value="{{old('password')}}" placeholder="Contraseña" required>
                    <label for="password" class="form-label">Contraseña</label>
                    <div class="invalid-feedback">
                        <small>Contraseña obligatoria</small> 
                    </div>
                </div>
                @error('password')
                    <small class="text-danger">* {{$message}}</small> <br>
                @enderror


                <div class="mt-4">
                    <input type="submit" value="Crear cuenta">
                </div>

            </form>
        </div>
    </div>
</div>
@endsection