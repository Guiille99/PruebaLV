@extends('layouts.plantilla-admin')
@section('title', 'Books | Añadir provincia')
@section('content')
<div class="form__modify__container register__section pt-4">
    <div class="title">
        <p>Añadir nueva provincia</p>
    </div>
    <form action="{{route('provincia.store')}}" method="post" class="needs-validation" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="container-fluid">
            <div class="row">
                {{-- Nombre --}}
                <div class="form-floating mt-3 col-md-6">
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{old('nombre')}}" placeholder="Nombre" required>
                    <label for="nombre" class="form-label ms-1">Nombre</label>
                    <div class="invalid-feedback">
                        <small>Nombre obligatorio</small> 
                    </div>
                    @error('nombre')
                        <small class="text-danger">* {{$message}}</small> <br>
                    @enderror
                </div>
        
                <div class="buttons__container mt-4">
                    <input type="submit" value="Añadir provincia" class="btn-add">
                    <a href="{{route('provincias.show')}}" class="btn-back">Volver</a>
                </div>
    
            </div>
        </div>

    </form>
</div>
@endsection