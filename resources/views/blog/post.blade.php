@extends('layouts.plantilla')
@section("title", "Books | $post->nombre")
@section('content')
<div class="container">
    <nav class="pt-3" aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{route('index')}}">Inicio</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{route('blog')}}">Blog</a></li> 
            <li class="breadcrumb-item" aria-current="page"><a href="{{route('show.categoria', $post->categoria->slug)}}">{{$post->categoria->nombre}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$post->nombre}}</li> 
        </ol>
    </nav>

    <div class="post__container">
        <div class="portada__container">
            <div class="portada mt-3" style="background-image: url('{{asset($post->portada)}}')">
                <p class="titulo">{{$post->nombre}}</p>
            </div>
            <div class="portada__details">
                <p>{{$post->user->nombre}} {{$post->user->apellidos}}</p>
                <p><i class="bi bi-calendar"></i> {{$post->created_at->format("d/m/Y")}}</p>
            </div>
        </div>

        <div class="content__container my-2">
            <div class="post-categoria__container">
                <div class="post">
                    <div class="post__content">
                        <div class="post__content-header">
                            <h1 class="post__content-titulo">{{$post->nombre}} <i role="checkbox" aria-checked="false" class="play-btn bi bi-volume-down-fill"></i></h1>
                        </div>
                        <div class="post__content-body">{!! $post->cuerpo !!}</div>
                    </div>
                    <div class="comentarios__container">
                        <div class="title">
                            <p>Comentarios</p>
                        </div>
                        <div class="comentarios">
                            @if (count($comentarios)==0)
                                <p class="text-center">No hay comentarios en este post</p>
                            @else
                                @foreach ($comentarios as $comentario)
                                    <div class="comentario">
                                        <figure class="img-profile">
                                            <img src="{{asset($comentario->user->avatar)}}" alt="Imagen de perfil de {{$comentario->user->username}}" class="img-fluid">
                                        </figure>
                                        <div class="user__info">
                                            <div class="user__info-username-date">
                                                <p class="username">{{$comentario->user->username}}</p>
                                                @if ($comentario->created_at->diffInDays() > 0)
                                                    <p class="date">{{$comentario->created_at->format("d/m/Y")}}</p>
                                                @else
                                                    <p class="date">{{ucfirst($comentario->created_at->diffForHumans())}}</p>
                                                @endif
                                            </div>
                                            <p>{{$comentario->cuerpo}}</p>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="paginator__container">
                                    {{$comentarios->links()}}
                                </div>
                            @endif
                        </div>

                        @if (Auth::check())
                            <div class="nuevo-comentario mt-5">
                                <div class="title">
                                    Añade un comentario
                                </div>
                                <div class="perfil-text">
                                    <figure class="img-profile">
                                        <img src="{{asset(Auth::user()->avatar)}}" alt="Imagen de perfil" class="img-fluid">
                                    </figure>
                                    <form action="{{route('add.comment', $post)}}" method="post" class="w-100">
                                        @csrf
                                        <div class="form-floating mb-2">
                                            <textarea id="comentarioTextarea" class="form-control" name="comentario" placeholder="Escriba aquí su comentario"></textarea>
                                            <label for="comentarioTextarea">Escriba aquí su comentario</label>
                                        </div>
                                        @error('comentario')
                                            <small class="text-danger mb-2">* {{$message}}</small> <br><br>
                                        @enderror
                                        <input type="submit" value="Añadir comentario" class="btn-add">
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="categoria__container">
                    <h4 class="titulo">Más artículos de '{{$post->categoria->nombre}}'</h4>
                    <ul>
                        @foreach ($postsMismaCategoria as $post)
                            <li>
                                <figure>
                                    <img src="{{asset($post->portada)}}" alt="{{$post->nombre}}" class="img-fluid">
                                </figure>
                                <a href="{{route('show.post', $post->slug)}}" class="titulo-post">{{$post->nombre}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
@section('script')
    @vite(["resources/js/posts.js"])
@endsection