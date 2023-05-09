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
        {{-- Session status --}}
        @if (session('status'))
            <div class="alert alert-success col-10 col-md-8 col-lg-4"><i class="bi bi-check-circle"></i> {{session('status')}}</div>
        @endif

        <div class="col-10 col-md-8 col-lg-5 login">
            <h2 class="login__title">Recuperar contraseña</h2>
            
            <form action="{{route('password.email')}}" method="post" class="needs-validation" novalidate>
                @csrf
                <p class="text-center fw-bold">Introduce tu dirección de correo electrónico y te enviaremos un enlace para restablecer tu contraseña.</p>
                <div class="form-floating mt-4">
                    <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}" placeholder="Enter email" required>
                    <label for="username" class="form-label">Email</label>
                    <div class="invalid-feedback">
                        <small>Introduzca un correo electrónico</small> 
                    </div>
                </div>
                @error('email')
                    <small class="text-danger">* {{$message}}</small> <br>
                @enderror

                <div class="mt-4">
                    <input type="submit" value="Recuperar contraseña">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection