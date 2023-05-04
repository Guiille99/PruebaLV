@extends('layouts.plantilla-editPerfil')
@section('content-profile')
@section('breadcrumb-profile')
<li class="breadcrumb-item"><a href="{{route('index')}}">Inicio</a></li>
<li class="breadcrumb-item" aria-current="page"><a href="{{route('user.editPerfil', Auth::user())}}">Mi cuenta</a></li> 
<li class="breadcrumb-item" aria-current="page"><a href="{{route('user.editPerfil-direcciones', Auth::user())}}">Mis direcciones</a></li> 
<li class="breadcrumb-item active" aria-current="page">Editar dirección</li> 
@endsection
@section('miCuenta-isActive', 'active')
    <div class="column account__details profile-section address__container">
        <div class="title">
            <p>DIRECCIÓN</p>
        </div>
        <div class="data py-2">
            <form action="{{route('update.address', $direccion)}}" method="post">
                @csrf
                @method('put')
                <div class="row py-2">
                    <div class="form-floating mt-3 col-md-6">
                        <input type="text" name="calle" id="calle" class="form-control" value="{{$direccion->calle}}" placeholder="Calle" required>
                        <label for="nombre" class="form-label ms-1">* Calle</label>
                        @error('calle')
                            <small class="text-danger">* {{$message}}</small> <br>
                        @enderror
                    </div>

                    <div class="form-floating mt-3 col-md-6">
                        <input type="number" name="num" id="num" class="form-control" value="{{$direccion->numero}}" placeholder="Número" max="999" required>
                        <label for="num" class="form-label ms-1">* Número</label>
                        @error('num')
                            <small class="text-danger">* {{$message}}</small> <br>
                        @enderror
                    </div>
                
                    <div class="form-floating mt-3 col-sm-6">
                        <select name="provincia" id="provincia" class="form-select">
                            @foreach ($provincias as $provincia)
                                @if ($provincia->nombre == $direccion->provincia->nombre)
                                <option value="{{$provincia->id}}" selected>{{$provincia->nombre}}</option>
                                @else
                                <option value="{{$provincia->id}}">{{$provincia->nombre}}</option>
                                @endif
                            @endforeach
                        </select>
                        <label for="provincia" class="form-label ms-1">* Provincia</label>
                        @error('provincia')
                            <small class="text-danger">* {{$message}}</small> <br>
                        @enderror
                    </div>

                    <div class="form-floating mt-3 col-md-6">
                        <input type="text" name="cp" id="cp" class="form-control" value="{{$direccion->cp}}" placeholder="Código Postal" required>
                        <label for="cp" class="form-label ms-1">* Código Postal</label>
                        @error('cp')
                            <small class="text-danger">* {{$message}}</small> <br>
                        @enderror
                    </div>
                </div>
                <input type="submit" value="Actualizar" class="boton">
            </form>
        </div>
    </div>
@endsection