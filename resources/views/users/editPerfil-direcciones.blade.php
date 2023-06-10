@extends('layouts.plantilla-editPerfil')
@section('content-profile')
@section('breadcrumb-profile')
<li class="breadcrumb-item"><a href="{{route('index')}}">Inicio</a></li>
<li class="breadcrumb-item" aria-current="page"><a href="{{route('user.editPerfil', $user)}}">Mi cuenta</a></li> 
<li class="breadcrumb-item active" aria-current="page">Mis direcciones</li> 
@endsection
@section('miCuenta-isActive', 'active')
    <div class="column account__details profile-section address__container">
        <div class="title">
            <p>DIRECCIÓN PRINCIPAL</p>
        </div>
        <div class="data py-2">
            @if (Auth::user()->direcciones->count()>0)
                <div class="alert alert-info" role="alert">
                    <i class="bi bi-info-circle"></i>
                    <span>Esta dirección se seleccionará por defecto para el envío</span>
                </div>
                @foreach (Auth::user()->direcciones as $direccion)
                    @if ($direccion->pivot->principal==1)
                    <p class="ps-4">
                        <i class="bi bi-star-fill"></i>
                        {{$direccion->calle}}, {{$direccion->numero}}, {{$direccion->cp}} - {{$direccion->provincia->nombre}}
                    </p>
                    @endif
                @endforeach
                @else
                <div class="alert alert-warning mt-2" role="alert">
                    <i class="bi bi-exclamation-triangle"></i>
                    <span>Actualmente usted no tiene ninguna dirección registrada</span>
                </div>
            @endif
        </div>

        <div class="title mt-4">
            <p>MIS DIRECCIONES</p>
        </div>

        <div class="data py-2">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <i class="bi bi-info-circle"></i>
                <span>Se permite un máximo de 3 direcciones</span>
            </div>

            <ul class="direcciones p-0">
                @foreach ($direcciones as $direccion)
                <li>
                    <form action="{{route('delete-address', [$user, $direccion])}}" method="post">
                        @csrf
                        @method('delete')
                        <div>
                            @if ($direccion->pivot->principal==1)
                                <i class="bi bi-star-fill"></i>
                            @endif
                            {{$direccion->calle}}, {{$direccion->numero}}, {{$direccion->cp}} - {{$direccion->provincia->nombre}}
                        </div>
                        <div class="d-flex gap-1">
                            <a href="{{route('edit.address', [$user, $direccion])}}" class="btn-modify"> <i class="bi bi-eye-fill"></i> Ver</a>
                            <button class="btn btn-danger">
                                <i class="bi bi-trash3"></i>
                                Eliminar
                            </button>
                        </div>
                    </form>
                </li>
                 @endforeach
            </ul>

            @if (Auth::user()->direcciones->count() < 3)
            <a href="{{route('address.create')}}" class="d-block mt-3 add-address-link"><i class="bi bi-plus"></i>Añadir dirección</a>
            @endif
        </div>

        @if (Auth::user()->direcciones->count()>0)
        <div class="title mt-4">
            <p>CAMBIAR DIRECCIÓN PRINCIPAL</p>
        </div>
        <div class="data py-4">
            <form action="{{route('update-principal-address', $user)}}" method="post" class="d-flex flex-column gap-3">
                @csrf
                @method('put')
                <select name="principalAddress" id="principalAddress" class="form-select">
                    @foreach ($user->direcciones as $direccion)
                        <option value="{{$direccion->id}}">{{$direccion->calle}}, {{$direccion->numero}}, {{$direccion->cp}} - {{$direccion->provincia->nombre}}</option>
                    @endforeach
                </select>
                <button type="submit" class="boton align-self-end">
                    <span>Actualizar</span>
                </button>
            </form>
        </div>
        @endif
    </div>
@endsection