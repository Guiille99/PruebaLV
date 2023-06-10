@extends('layouts.plantilla')
@section("title", "Books | $categoria->nombre")
@if (count($posts) == 0)
    @section('body-class', 'd-flex flex-column justify-content-between vh-100')    
@endif
@section('content')
    @if (count($posts) == 0)
    <div class="container flex-grow-1">
    @else
    <div class="container">
    @endif
        <nav class="pt-3" aria-label="breadcrumb">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="{{route('index')}}">Inicio</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('blog')}}">Blog</a></li> 
                <li class="breadcrumb-item active" aria-current="page"><a href="{{route('show.categoria', $categoria->slug)}}">{{$categoria->nombre}}</a></li>
            </ol>
        </nav>

        <div class="posts-categoria__container mt-2">
            <div class="title">
                <h1>{{$categoria->nombre}}</h1>
            </div>
            @if (count($posts)>0)
            <div class="posts__container">
                @foreach ($posts as $post)
                    <div class="blog__card">
                        <a href="{{route('show.post', $post->slug)}}"></a>
                        <figure class="m-0">
                            <img src="{{asset($post->portada)}}" alt="{{$post->nombre}}" class="img-fluid">
                        </figure>
                        <p class="titulo">{{$post->nombre}}</p>
                    </div>
                @endforeach
            </div>
        
            @else
                <div class="alert alert-warning mt-2" role="alert">
                    <i class="bi bi-exclamation-triangle"></i>
                    <span>Actualmente no existe ningún post para esta categoría</span>
                </div>
            @endif
        </div>
    </div>
@endsection