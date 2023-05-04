@extends('layouts.plantilla-editPerfil')
@section('content-profile')
@section('breadcrumb-profile')
<li class="breadcrumb-item"><a href="{{route('index')}}">Inicio</a></li>
<li class="breadcrumb-item" aria-current="page"><a href="{{route('user.editPerfil', $user)}}">Mi cuenta</a></li> 
<li class="breadcrumb-item active" aria-current="page">Contraseña</li> 
@endsection
@section('miCuenta-isActive', 'active')
    <div class="column account__details profile-section password__container">
        <div class="title">
            <p>MI CONTRASEÑA</p>
        </div>

        <div class="data mt-2">
            <form action="{{route('change.password')}}" method="post">
                @csrf
                @method('put')
                <div class="row row-gap-3">
                    <div class="form-floating col-lg-4">
                        <input type="password" name="current_password" id="current_password" class="form-control" value="{{old('password')}}" placeholder="Password" required>
                        <i class="bi bi-eye togglePassword"></i>
                        <label for="current_password" class="form-label ms-1">Contraseña</label>
                        @error('current_password')
                            <small class="text-danger">* {{$message}}</small> <br>
                        @enderror
                    </div>
                    <div class="form-floating col-lg-4">
                        <input type="password" name="password" id="password" class="form-control" value="{{old('password')}}" placeholder="Password" required>
                        <i class="bi bi-eye togglePassword"></i>
                        <label for="password" class="form-label ms-1">Nueva contraseña</label>
                        @error('password')
                            <small class="text-danger">* {{$message}}</small> <br>
                        @enderror
                    </div>
                    <div class="form-floating col-lg-4">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" value="{{old('password')}}" placeholder="Password" required>
                        <i class="bi bi-eye togglePassword"></i>
                        <label for="password_confirmation" class="form-label ms-1">Confirmar contraseña</label>
                        @error('password_confirmation')
                            <small class="text-danger">* {{$message}}</small> <br>
                        @enderror
                    </div>
                </div>

                <input type="submit" class="boton mt-2" value="Actualizar">
            </form>
        </div>
    </div>
@endsection