@extends('layouts.plantilla-editPerfil')
@section('content-profile')
@section('breadcrumb-profile')
<li class="breadcrumb-item"><a href="{{route('index')}}">Inicio</a></li>
<li class="breadcrumb-item" aria-current="page"><a href="{{route('user.editPerfil', $user)}}">Mi cuenta</a></li> 
<li class="breadcrumb-item active" aria-current="page">Desuscribirse de Newsletter</li> 
@endsection
@section('miCuenta-isActive', 'active')
    <div class="column account__details profile-section unsuscribe-newsletter__container">
        <div class="title">
            <p>Baja del Newsletter</p>
        </div>
        <div class="data py-1">
            @if ($isNewsletterRegister)
            <div class="description">
                <p>¡Lamentamos que te vayas!</p>
                <p>Si deseas darte de baja de nuestro Newsletter, el proceso es muy sencillo. Solo tienes que introducir tu contraseña en la parte inferior de la página. Si tienes algún problema, no dudes en ponerte en contacto con nosotros. ¡Gracias por haber formado parte de nuestra comunidad y esperamos verte pronto de nuevo!</p>
                <p>Para continuar con la eliminación de la cuenta, introduzca su contraseña a continuación:</p>
            </div>

            <form action="{{route('unsuscribe.newsletter')}}" method="post">
                @csrf
                @method('delete')
                <div class="form-floating input__container col-lg-4">
                    <input type="password" name="password" id="password" class="form-control" value="{{old('password')}}" placeholder="Password" required>
                    <i class="bi bi-eye togglePassword"></i>
                    <label for="password" class="form-label ms-1">Confirme la contraseña</label>
                </div>
                
                <button class="btn btn-danger">
                    <i class="bi bi-trash3"></i>
                    <span>Darse de baja</span>
                </button>
            </form>
            @error('password')
                <small class="text-danger">* {{$message}}</small> <br>
            @enderror
            @else
                <div class="alert alert-warning mt-2" role="alert">
                    <i class="bi bi-exclamation-triangle"></i>
                    <span>Actualmente usted no está suscrito a nuestro Newsletter</span>
                </div>
            @endif
        </div>
    </div>
@endsection