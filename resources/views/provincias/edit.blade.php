@extends('layouts.plantilla-admin')
@section('title', 'Books | Modificación de provincia')
@section('content')
<div class="form__modify__container profile-section register__section pt-4">
   
    <div class="title">
        <p>Modificación de la provincia {{$provincia->nombre}}</p>
    </div>
    <form action="{{route('provincia.update', $provincia)}}" method="post" class="needs-validation" enctype="multipart/form-data" novalidate>
        @csrf
        @method('put')
        <div class="container-fluid">
            <div class="row">
                <div class="form-floating mt-3 col-md-6">
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{$provincia->nombre}}" placeholder="Nombre" required>
                    <label for="nombre" class="form-label ms-1">Nombre</label>
                    <div class="invalid-feedback">
                        <small>Nombre obligatorio</small> 
                    </div>
                    @error('nombre')
                        <small class="text-danger">* {{$message}}</small> <br>
                    @enderror
                </div>
                <div class="buttons__container mt-4">
                    <input type="submit" value="Modificar" class="btn-modify">
                    <a href="{{route('provincias.show')}}" class="btn-back">Volver</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection