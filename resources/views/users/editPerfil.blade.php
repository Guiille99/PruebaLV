@extends('layouts.plantilla-editPerfil')
@section('content-profile')
@section('miCuenta-isActive', 'active')
    <div class="column account__details">
        <div class="content__header w-100" style="background-image: url({{asset('uploads/bg-green.jpg')}})">
            <h3>¡Bienvenido, <br> {{Auth::user()->nombre}}!</h3>
            <figure>
                <img src="{{asset(Auth::user()->avatar)}}" alt="" class="img-fluid">
            </figure>
            <p><span id="nPedidos">0</span> Pedidos</p>
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
                    <form action="" method="post">
                        @csrf
                        @method('put')
                        <div class="d-flex gap-4">
                            <div class="form-floating">
                                <input type="password" name="password" id="password" class="form-control" value="{{old('password')}}" placeholder="Password" required>
                                <i class="bi bi-eye togglePassword"></i>
                                <label for="password" class="form-label">Contraseña</label>
                            </div>
                            <div class="form-floating">
                                <input type="password" name="password" id="password" class="form-control" value="{{old('password')}}" placeholder="Password" required>
                                <i class="bi bi-eye togglePassword"></i>
                                <label for="password" class="form-label">Nueva contraseña</label>
                            </div>
                            <div class="form-floating">
                                <input type="password" name="password" id="password" class="form-control" value="{{old('password')}}" placeholder="Password" required>
                                <i class="bi bi-eye togglePassword"></i>
                                <label for="password" class="form-label">Confirmar contraseña</label>
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
                    <a href="" class="d-block mt-3"><i class="bi bi-plus"></i>Añadir dirección</a>
                </div>
            </div>
        </div>
    </div>
@endsection