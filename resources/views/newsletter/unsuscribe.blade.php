@extends('layouts.plantilla')
@section('title', 'Books | Baja del Newsletter')
@section('body-class', 'vh-100 d-flex flex-column justify-content-between')
    
@section('content')
<div class="container flex-grow-1">
    @if (session('message_success'))
    <div class="alert alert-success my-2"><i class="bi bi-check-circle"></i> {{session('message_success')}}</div> 
    @endif

    <div class="column account__details profile-section unsuscribe-newsletter__container py-3">
        <div class="title">
            <p>Baja del Newsletter</p>
        </div>
        <div class="data py-1">
            <div class="description">
                <p>¡Lamentamos que te vayas!</p>
                <p>Si deseas darte de baja de nuestro Newsletter, el proceso es muy sencillo. Solo tienes que introducir tu contraseña en la parte inferior de la página. Si tienes algún problema, no dudes en ponerte en contacto con nosotros. ¡Gracias por haber formado parte de nuestra comunidad y esperamos verte pronto de nuevo!</p>
                <p>Para continuar con la eliminación de la cuenta, introduzca su contraseña a continuación:</p>
            </div>
    
            <form action="{{route('unsuscribe.newsletter.sendEmail')}}" method="post">
                @csrf
                <div class="form-floating input__container col-lg-4">
                    <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}" placeholder="Correo electrónico" required>
                    {{-- <i class="bi bi-eye togglePassword"></i> --}}
                    <label for="email" class="form-label ms-1">Escriba su correo electrónico</label>
                </div>
                
                <button class="btn btn-danger">
                    <i class="bi bi-trash3"></i>
                    <span>Darse de baja</span>
                </button>
            </form>
            @error('email')
                <small class="text-danger">* {{$message}}</small> <br>
            @enderror
        </div>
    </div>
</div>
@endsection