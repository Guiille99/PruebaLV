@extends('layouts.plantilla')
@section("title", "Books | Listado")
{{-- @section("generos_libros")
    @foreach ($generos as $genero)
        <li><a class="dropdown-item" href="{{route('libros.filter', $genero->genero)}}">{{$genero->genero}}</a></li>
    @endforeach
@endsection --}}
@section('content')
{{-- <h1 class="text-center">Página para mostrar el listado de libros</h1> --}}

    @if (count($libros)==0)
    @section('body-class', 'd-flex flex-column justify-content-between vh-100')

    <h1 class="text-center fw-bold p-5 p-md-0">No se ha encontrado ningún artículo :(</h1>
    @else

    <div class="container-fluid mt-5">
        <div class="row mt-5">
            <div class="title__container">
                @if ($filtro=="novedades")
                    <h1 class="text-center">Libros más recientes</h1>
                @else
                    <h1 class="text-center">Libros de {{$filtro}}</h1>
                @endif
            </div>
            <div class="recomendados__container col-6 col-md-10 m-auto">
                <div class="libros__container mt-3">
                    @foreach ($libros as $libro)
                    <div class="card">
                        <figure class="m-0">
                           <a href="{{route('libros.show', $libro)}}"><img src="{{asset($libro->portada)}}" alt="{{$libro->titulo}}" class="img-fluid"></a> 
                        </figure>
                        <div class="libro__info">
                            <h4 class="libro__titulo" title="{{$libro->titulo}}">{{$libro->titulo}}</h4>
                            <p class="libro__autor">{{$libro->autor}}</p>
                            <p class="libro__precio">{{$libro->precio}}€</p>
                            @if ($libro->stock>0)
                            <form action="" method="get">
                                @csrf
                                @if (Auth::check()) {{-- Si hay una sesión iniciada --}}
                                    <input type="submit" value="Comprar" class="boton">
                                 @else
                                    <input type="submit" value="Comprar" class="boton" disabled>
                                @endif
                            </form>
                            @else
                            <span class="btn-delete">Fuera de Stock</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    
                </div> 
                <div class="my-3">
                    {{$libros->links()}}
                </div>
                
            </div>
        </div>
    </div>
    @endif
@endsection