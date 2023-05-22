@extends('layouts.plantilla')
@section("title", "Books | $libro->titulo")
@section("generos_libros")
    @foreach ($generos as $genero)
        <li><a class="dropdown-item" href="{{route('libros.filter', $genero->genero)}}">{{$genero->genero}}</a></li>
    @endforeach
@endsection
@section('content')
{{-- {{count(session()->get('wishlist'))}} --}}
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
                <form action="" method="get" class="form-add-to-cart">
                    @csrf
                    @if (Auth::check()) {{-- Si hay una sesión iniciada --}}
                        <button type="submit" class="boton btn-carrito" data-id="{{$libro->id}}"><i class="bi bi-cart"></i> Añadir a mi cesta</button>
                    @else
                        <button type="submit" class="boton btn-carrito" disabled><i class="bi bi-cart"></i> Añadir a mi cesta</button>
                    @endif
                </form>
                
                {{-- Si no hay stock --}}
                @else
                <p class="stock text-danger">Sin stock</p>
                <button class="boton btn-carrito" disabled><i class="bi bi-cart"></i> Añadir a mi cesta</button>
            @endif
                {{-- @if (Auth::check())
                    @if (session()->get('wishlist')!=null && array_key_exists($libro->id,session()->get('wishlist')))
                        <form action="{{route('delete_to_wishlist', $libro)}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="boton btn-carrito mt-2" data-id="{{$libro->id}}"><i class="bi bi-heart-fill"></i> Eliminar de la lista de deseos</button>
                        </form>
                    @else
                        <form action="{{route('add_to_wishlist', $libro)}}" method="post">
                            @csrf
                            <button type="submit" class="btn-outline-green mt-2" data-id="{{$libro->id}}"><i class="bi bi-heart"></i> Añadir a la lista de deseos</button>
                        </form>
                    @endif
                @else
                <button class="btn-outline-green mt-2" disabled><i class="bi bi-heart"></i> Añadir a la lista de deseos</button>
                @endif --}}
                @livewire('wishlist-component', ['libro'=>$libro])

        </div>
    </div>
@endsection
@section('script')
  <script>
    //Definición de rutas
    let url = "{{route('add_to_cart')}}";
    let urlCartContent = "{{route('offcanvas-cart-content')}}";
    // let urlCantidadCarrito = "{{route('cantidadCarrito')}}";
</script>
@vite(['resources/js/cart.js'])
@endsection