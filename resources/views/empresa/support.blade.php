@extends('layouts.plantilla')
@section('title', 'Books | Ayuda')    
@section('content')
<div class="container">
    <nav class="pt-3" aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{route('index')}}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ayuda</li> 
        </ol>
    </nav>
    <div class="info-empresa__container">
        <div class="portada">
            <h1 id="title">AYUDA</h1>
        </div>
        <div class="info__content support_container">
            <h3 class="fw-bold">Preguntas frecuentes</h3>
            <div class="preguntas-frecuentes__grid">
                <a href="{{route('saber-estado-pedido')}}">
                    <div class="pregunta">
                        <p>¿Cómo puedo saber el estado de mi pedido?</p>
                    </div>
                </a>
                <a href="{{route('support.metodos-pago')}}">
                    <div class="pregunta">
                        <p>¿Cuáles son los métodos de pago disponibles?</p>
                    </div>
                </a>
                <a href="{{route('support.cancelar-pedido')}}">
                    <div class="pregunta">
                        <p>¿Cómo puedo cancelar un pedido?</p>
                    </div>
                </a>
                <a href="{{route('support.devolver-pedido')}}">
                    <div class="pregunta">
                        <p>¿Se puede devolver un pedido?</p>
                    </div>
                </a>
                <a href="{{route('support.direccion-envio')}}">
                    <div class="pregunta">
                        <p>No puedo añadir una nueva dirección de envío</p>
                    </div>
                </a>
                <a href="{{route('support.baja-newsletter')}}">
                    <div class="pregunta">
                        <p>¿Cómo puedo darme de baja del Newsletter?</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection