@extends('layouts.plantillalogin')
@section('title', "Books | Recuperar contraseña")

@section('content')
<div class="container-fluid vh-100 form__hero" style="background-image: url({{asset('uploads/bookshop.jpg')}})">
    <div class="row flex-column gap-2 justify-content-center align-items-center h-100">
        <figure class="w-auto">
            <a href="{{route('index')}}">
                <img src="{{asset('uploads/logo-nombre2.svg')}}" alt="Logo">
            </a>
        </figure>
        <div class="col-10 col-md-8 col-lg-5 login">
            <h2 class="login__title">Reestablece tu contraseña</h2>
            
            <form action="{{route('password.update')}}" method="post" class="needs-validation" novalidate>
                @csrf
                <input type="hidden" name="token" value="{{$token}}">
                <div class="form-floating mt-4">
                    <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}" placeholder="Enter email" required>
                    <label for="username" class="form-label">Correo electrónico</label>
                    <div class="invalid-feedback">
                        <small>Introduzca un correo electrónico</small> 
                    </div>
                </div>

                @error('email')
                    <small class="text-danger">* {{$message}}</small> <br>
                @enderror

                <div class="form-floating mt-3">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                    <i id="togglePassword" class="bi bi-eye"></i>
                    <label for="password" class="form-label">Nueva contraseña</label>
                    <div class="invalid-feedback">
                        <small>Introduzca una contraseña</small> 
                    </div>
                </div>

                <div class="form-floating mt-3">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Password" required>
                    <i id="togglePasswordConfirm" class="bi bi-eye"></i>
                    <label for="password" class="form-label">Repite la contraseña</label>
                    <div class="invalid-feedback">
                        <small>Introduzca una contraseña</small> 
                    </div>
                </div>

                @error('password')
                    <small class="text-danger">* {{$message}}</small> <br>
                @enderror

                <div class="mt-4">
                    <input type="submit" value="Cambiar contraseña">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection