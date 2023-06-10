@extends('layouts.plantilla')
@section("title", "Books | Blog")

@section('content')
    <div class="container">
        <nav class="pt-3" aria-label="breadcrumb">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="{{route('index')}}">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Blog</li> 
            </ol>
        </nav>
    </div>
    {{-- IMÁGENES PRINCIPALES --}}
    <div class="imagenes__principales py-4 col-md-10 col-lg-9">
        @foreach ($postsDestacados as $post)
        <div class="destacada2 blog__card">
            <a href="{{route('show.post', $post->slug)}}"></a>
            <figure>
                <img src="{{asset($post->portada)}}" alt="{{$post->nombre}}" class="img-fluid">
            </figure>
            @if ($post->nombre == "Día de la mujer")
            <div class="mensaje__oferta">
                <p> <span class="porcentaje">5%</span> de dto.</p>
            </div>
            @endif
            <p>{{$post->nombre}}</p>
        </div>
        @endforeach
    </div>

    <main class="blog-main-content py-3 pb-5">
        {{-- ÚLTIMAS RESEÑAS --}}
        <div class="resenas__container">
            <div class="resenas">
                <h1>ÚLTIMAS RESEÑAS</h1>
        
                <div class="resenas__grid col-10 col-lg-9">
                    @foreach ($ultimasResenas as $resena)
                    <div class="resena">
                        <a href="{{route('show.post', $resena->slug)}}"></a>
                        <figure>
                            <img src="{{asset($resena->thumbnail)}}" alt="{{$resena->nombre}}" class="img-fluid">
                        </figure>
                        <div class="resena__info">
                            <h5>{{$resena->nombre}}</h5>
        
                            <div class="resena__info__publicacion">
                                <p class="resena__autor">{{$resena->user->nombre}} {{$resena->user->apellidos}}</p>
                                <p class="resena__fecha">{{$resena->created_at->format("d/m/Y")}}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <h1 class="text-center">CATEGORÍAS</h1>
        <div class="categorias__container col-10 col-md-9 mb-5">
            @foreach ($categorias as $categoria)
                <div class="categoria {{$categoria->slug}}">
                    <a href="{{route('show.categoria', $categoria->slug)}}"></a>
                    <p class="title">{{$categoria->nombre}}</p>
                </div>
            @endforeach
        </div>

        {{-- VENTAJAS --}}
            <div class="ventajas__container col-10 col-md-9">
                <div class="ventaja">
                    <i class="bi bi-bag-check"></i>
                    <p>Compra segura</p>
                </div>
    
                <div class="ventaja">
                    <i class="bi bi-truck"></i>
                    <p>Envío gratis a partir de 15€</p>
                </div>
    
                <div class="ventaja">
                    <i class="bi bi-shop"></i>
                    <p>Recogida en tienda gratis</p>
                </div>
    
                <div class="ventaja">
                    <i class="bi bi-arrow-clockwise"></i>
                    <p>Devolución gratis hasta 30 días</p>
                </div>
            </div>
    </main>
@endsection