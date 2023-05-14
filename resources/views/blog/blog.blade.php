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
        <div class="destacada1 blog__card">
            <a href="{{route('show.post', $postsDestacados[0]->slug)}}"></a>
            <figure>
                <img src="{{asset($postsDestacados[0]->portada)}}" alt="{{$postsDestacados[0]->nombre}}" class="img-fluid">
            </figure>
            <p>{{$postsDestacados[0]->nombre}}</p>
        </div>

        <div class="destacada2 blog__card">
            <a href="{{route('show.post', $postsDestacados[1]->slug)}}"></a>
            <figure>
                <img src="{{asset($postsDestacados[1]->portada)}}" alt="{{$postsDestacados[1]->nombre}}" class="img-fluid">
            </figure>
            <div class="mensaje__oferta">
                <p> <span class="porcentaje">5%</span> de dto.</p>
            </div>
            <p>{{$postsDestacados[1]->nombre}}</p>
        </div>

        <div class="destacada3 blog__card">
            <a href="{{route('show.post', $postsDestacados[2]->slug)}}"></a>
            <figure>
                <img src="{{asset($postsDestacados[2]->portada)}}" alt="{{$postsDestacados[2]->nombre}}" class="img-fluid"> 
            </figure>
            <p>{{$postsDestacados[2]->nombre}}</p>
        </div>
    </div>

    {{-- ÚLTIMAS RESEÑAS --}}
    <main class="resenas__container py-3 pb-5">
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