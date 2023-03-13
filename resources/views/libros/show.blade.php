@extends('layouts.plantilla')
@section("title", "Books | Nombre del libro")
@section("generos_libros")
    @foreach ($generos as $genero)
        <li><a class="dropdown-item" href="{{route('libros.filter', $genero->genero)}}">{{$genero->genero}}</a></li>
    @endforeach
@endsection
@section('content')
{{-- {{$libro}} --}}
    <div class="libro__container py-4">
        <div class="portada__container">
            <figure>
                <img src="{{asset($libro->portada)}}" alt="{{$libro->titulo}}" class="d-block img-fluid">
            </figure>

        </div>
        {{-- INFO DEL LIBRO --}}
        <div class="libro__info">
            <div class="libro__info__header">
                <h2 class="libro__info__titulo">{{$libro->titulo}}</h2>
                <p class="libro__info__autor">{{$libro->autor}}</p>
            </div>

            <div class="libro__info__body">
                <p><strong>Editorial: </strong>{{$libro->editorial}}</p>
                <p><strong>Fecha de publicación: </strong>{{$libro->fecha_publicacion}}</p>
                <p><strong>Género: </strong>{{$libro->genero}}</p>
                <p><strong>Valoración: </strong>{{$libro->valoracion}}/10</p>
                <p><strong>Páginas: </strong>{{$libro->paginas}}</p>
            </div>
        </div>

        {{-- PRECIO Y AÑADIR A CESTA --}}
        <div class="precio__carrito">
            <div class="precio__container">
                <p class="precio">{{$libro->precio}}€</p>
                <small class="iva">IVA incluido</small>
            </div>

            {{-- Si hay stock del libro --}}
            @if ($libro->stock>0) 
                <p class="stock text-success">En stock</p>
                <button class="boton btn-carrito"><i class="bi bi-cart"></i> Añadir a mi cesta</button>
                
                {{-- Si no hay stock --}}
                @else
                <p class="stock text-danger">Sin stock</p>
                <button class="boton btn-carrito" disabled><i class="bi bi-cart"></i> Añadir a mi cesta</button>
            @endif

        </div>
    </div>
@endsection