@extends('layouts.plantilla')
@section('title', 'Cómo devolver un pedido')
@section('body-class', 'vh-100 d-flex flex-column justify-content-between')
@section('content')
<div class="container flex-grow-1">
    <nav class="pt-3" aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{route('index')}}">Inicio</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{route('support')}}">Ayuda</a></li> 
            <li class="breadcrumb-item active" aria-current="page">¿Se puede devolver un pedido?</li> 
        </ol>
    </nav>
    <div class="info-empresa__container support__container py-3">
        <div class="title__container">
            <h1 class="title">¿Se puede devolver un pedido?</h1>
        </div>
        <div class="support-answer py-3">
            <p>Si te ha llegado tu pedido y no es lo que esperadas, no te preocupes. En <i><strong>Books</strong></i> podrás devolver tus pedidos de forma sencilla.</p>
            <p>Para ello, deberás ponerte en contacto con nosotros a través de los siguientes métodos:</p>
            <ul>
                <li><strong>Email: books2023.info@gmail.com</strong></li>
                <li><strong>Teléfono: 623456789</strong></li>
                <li><strong>De manera presencial en nuestra tienda.</strong></li>
            </ul>
            <p>Ten en cuenta que tienes <strong>30 días</strong> para devolver el pedido. Pasados esos días, ya no será posible realizar ninguna devolución.</p>
        </div>
    </div>
</div>
@endsection    