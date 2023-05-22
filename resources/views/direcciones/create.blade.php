@extends('layouts.plantilla-editPerfil')
@section('content-profile')
@section('breadcrumb-profile')
<li class="breadcrumb-item"><a href="{{route('index')}}">Inicio</a></li>
<li class="breadcrumb-item" aria-current="page"><a href="{{route('user.editPerfil', Auth::user())}}">Mi cuenta</a></li> 
<li class="breadcrumb-item" aria-current="page"><a href="{{route('user.editPerfil-direcciones', Auth::user())}}">Mis direcciones</a></li> 
<li class="breadcrumb-item active" aria-current="page">Nueva dirección</li> 
@endsection
@section('miCuenta-isActive', 'active')
    <div class="column account__details profile-section address__container">
        <div class="title">
            <p>NUEVA DIRECCIÓN</p>
            <p class="require-data-message">* Dato obligatorio</p>
        </div>
        <div class="data py-2">
            <form action="{{route('store.address')}}" method="post">
                @csrf
                <div class="row py-2">
                    <div class="form-floating mt-3 col-md-6">
                        <input type="text" name="calle" id="calle" class="form-control" placeholder="Calle" required>
                        <label for="calle" class="form-label ms-1">* Calle</label>
                        @error('calle')
                            <small class="text-danger">* {{$message}}</small> <br>
                        @enderror
                    </div>

                    <div class="form-floating mt-3 col-md-6">
                        <input type="number" name="num" id="num" class="form-control" placeholder="Número" max="999" required>
                        <label for="num" class="form-label ms-1">* Número</label>
                        @error('num')
                            <small class="text-danger">* {{$message}}</small> <br>
                        @enderror
                    </div>
                
                    <div class="form-floating mt-3 col-sm-6">
                        <select name="provincia" id="provincia" class="form-select">
                            @foreach ($provincias as $provincia)
                                <option value="{{$provincia->id}}">{{$provincia->nombre}}</option>
                            @endforeach
                        </select>
                        <label for="provincia" class="form-label ms-1">* Provincia</label>
                        @error('provincia')
                            <small class="text-danger">* {{$message}}</small> <br>
                        @enderror
                    </div>

                    <div class="form-floating mt-3 col-md-6">
                        <input type="text" name="cp" id="cp" class="form-control" placeholder="Código Postal" required>
                        <label for="cp" class="form-label ms-1">* Código Postal</label>
                        @error('cp')
                            <small class="text-danger">* {{$message}}</small> <br>
                        @enderror
                    </div>

                    <div class="mt-3 d-flex gap-2">
                        <label for="principal">Dirección principal</label>
                        <input type="checkbox" name="principal" id="principal">
                    </div>
                </div>
                <input type="submit" value="Añadir" class="boton">
            </form>
        </div>
    </div>
@endsection