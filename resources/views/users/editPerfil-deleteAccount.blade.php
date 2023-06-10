@extends('layouts.plantilla-editPerfil')
@section('content-profile')
@section('breadcrumb-profile')
<li class="breadcrumb-item"><a href="{{route('index')}}">Inicio</a></li>
<li class="breadcrumb-item" aria-current="page"><a href="{{route('user.editPerfil', $user)}}">Mi cuenta</a></li> 
<li class="breadcrumb-item active" aria-current="page">Eliminar cuenta</li> 
@endsection
@section('miCuenta-isActive', 'active')
    <div class="column account__details profile-section delete-account__container">
        <div class="title">
            <p>ELIMINAR CUENTA</p>
        </div>
        <div class="data py-1">
            <div class="description">
                <p>¡Qué pena que nuestros caminos se separen!</p>
                <p>Si crees que no vas a volver a usar nuestra tienda online puedes solicitar la eliminación de tu cuenta. Recuerda que esta acción no se podrá deshacer y por lo tanto no podrás reactivar la cuenta o recuperar ninguna información de la misma ya que la cuenta junto con sus datos se eliminarán definitivamente del sistema.</p>
                <p>Para continuar con la eliminación de la cuenta, introduzca su contraseña a continuación:</p>
            </div>

            <form action="{{route('user.destroy-perfil', Auth::user())}}" method="post">
                @csrf
                @method('delete')
                <div class="form-floating input__container col-lg-4">
                    <input type="password" name="password" id="password" class="form-control" value="{{old('password')}}" placeholder="Password" required>
                    <i class="bi bi-eye togglePassword"></i>
                    <label for="password" class="form-label ms-1">Confirme la contraseña</label>
                </div>
                
                <button class="btn btn-danger">
                    <i class="bi bi-trash3"></i>
                    <span>Eliminar cuenta</span>
                </button>
            </form>
            @error('password')
                <small class="text-danger">* {{$message}}</small> <br>
            @enderror
        </div>
    </div>
@endsection