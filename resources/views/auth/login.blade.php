@extends('layouts.plantillalogin')
@section('title', "Login")

@section('content')
<div class="container-fluid vh-100 form__hero" style="background-image: url({{asset('uploads/bookshop.jpg')}})">
    <div class="row flex-column gap-2 justify-content-center align-items-center h-100">
        <figure class="w-auto">
            <a href="{{route('index')}}">
                <img src="{{asset('uploads/logo-nombre2.svg')}}" alt="Logo">
            </a>
        </figure>

        {{-- Session status --}}
        @if (session('status'))
            <div class="alert alert-success col-10 col-md-8 col-lg-4"><i class="bi bi-check-circle"></i> {{session('status')}}</div>
        @endif
        
        <div class="col-10 col-md-8 col-lg-4 login">
            <h2 class="login__title">LOGIN</h2>
            
            <form action="{{route("login.store")}}" method="post" class="needs-validation" novalidate>
                @csrf
                <div class="form-floating mt-4">
                    <input type="text" name="username" id="username" class="form-control" value="{{old('username')}}" placeholder="Enter email" required>
                    <label for="username" class="form-label">Usuario</label>
                    <div class="invalid-feedback">
                        <small>Introduzca un usuario</small> 
                    </div>
                </div>
                @error('username')
                    <small class="text-danger">* {{$message}}</small> <br>
                @enderror

                <div class="form-floating mt-3">
                    <input type="password" name="password" id="password" class="form-control" value="{{old('password')}}" placeholder="Password" required>
                    <i id="togglePassword" class="bi bi-eye"></i>
                    <label for="password" class="form-label">Contraseña</label>
                    <div class="invalid-feedback">
                        <small>Introduzca una contraseña</small> 
                    </div>
                </div>
                @error('password')
                    <small class="text-danger">* {{$message}}</small> <br>
                @enderror
                @if (Session::has('error'))
                    <small class="text-danger">{{Session::get('error')}}</small>
                @endif

                <div class="mt-3 d-flex justify-content-between gap-2 flex-wrap">
                    <div class="form-check form-switch">
                        <label class="form-check-label" for="checkRemember">Recuérdame</label>
                        <input class="form-check-input" type="checkbox" role="switch" id="checkRemember" name="remember">
                    </div>

                    <div class="d-flex flex-column gap-2">
                        <a href="{{route('register.index')}}" class="nocount-link">¿No tienes cuenta? Regístrate</a>
                        <a href="{{route('password.request')}}" class="nocount-link">¿Olvidaste la contraseña?</a>
                    </div>
                </div>

                <div class="mt-4">
                    <input type="submit" value="Iniciar Sesión">
                </div>

            </form>
           
        </div>
    </div>

</div>

@endsection