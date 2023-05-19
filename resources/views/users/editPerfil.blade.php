@extends('layouts.plantilla-editPerfil')
@section('content-profile')
@section('breadcrumb-profile')
<li class="breadcrumb-item"><a href="{{route('index')}}">Inicio</a></li>
<li class="breadcrumb-item active" aria-current="page">Mi cuenta</li> 
@endsection
@section('miCuenta-isActive', 'active')
    <div class="column account__details w-100">
        <div class="content__header w-100" style="background-image: url({{asset('uploads/bg-green.jpg')}})">
            <h3>¡Bienvenido, <br> {{Auth::user()->nombre}}!</h3>
            <figure class="m-0">
                <img src="{{asset(Auth::user()->avatar)}}" alt="Imagen de perfil" class="img-fluid">
            </figure>
            <p><span id="nPedidos">{{count(Auth::user()->pedidos)}}</span> {{(count(Auth::user()->pedidos)) == 1 ? "Pedido" : "Pedidos"}}</p>
        </div>

        <div class="account__content mt-2">
            <div class="account-section mis__datos">
                <div class="title">
                    <span>MIS DATOS</span>
                </div>

                <div class="info mis__datos__info">
                    <p>Nombre: <span class="fw-bold">{{Auth::user()->nombre}}</span></p>
                    <p>Apellidos: <span class="fw-bold">{{Auth::user()->apellidos}}</span></p>
                    <p>Email: <span class="fw-bold">{{Auth::user()->email}}</span></p>
                    <p>Nombre de usuario: <span class="fw-bold">{{Auth::user()->username}}</span></p>
                </div>
            </div>

            <div class="account-section my-password mt-2">
                <div class="title">
                    <span>CONTRASEÑA</span>
                </div>
                <div class="info password__info">
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

                        <input type="submit" class="boton" value="Actualizar">
                    </form>
                </div>
            </div>

            <div class="account-section mis-direcciones mt-2">
                <div class="title">
                    <span>MIS DIRECCIONES</span>
                </div>
                <div class="info direcciones__info">
                    <ul>
                        @foreach (Auth::user()->direcciones as $direccion)
                            <li>
                                @if ($direccion->pivot->principal==1)
                                    <i class="bi bi-star-fill"></i>
                                @endif
                                {{$direccion->calle}}, {{$direccion->numero}}, {{$direccion->cp}} - {{$direccion->provincia->nombre}}
                            </li>
                        @endforeach
                    </ul>
                    @if (Auth::user()->direcciones->count() < 3)
                    <a href="{{route('address.create')}}" class="d-block mt-3 add-address-link"><i class="bi bi-plus"></i>Añadir dirección</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection