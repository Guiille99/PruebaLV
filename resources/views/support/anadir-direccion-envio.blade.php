@extends('layouts.plantilla')
@section('title', 'Cómo devolver un pedido')
@section('body-class', 'vh-100 d-flex flex-column justify-content-between')
@section('content')
<div class="container flex-grow-1">
    <nav class="pt-3" aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{route('index')}}">Inicio</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{route('support')}}">Ayuda</a></li> 
            <li class="breadcrumb-item active" aria-current="page">No puedo añadir una nueva dirección de envío</li> 
        </ol>
    </nav>
    <div class="info-empresa__container support__container py-3">
        <div class="title__container">
            <h1 class="title">No puedo añadir una nueva dirección de envío</h1>
        </div>
        <div class="support-answer py-3">
            <p>En <strong>Books</strong> te ofrecemos la oportunidad de añadir tu dirección para recibir los pedidos a casa. Para añadir una dirección es necesario ir a <i><strong>Perfil > Mis direcciones</strong></i>. Una vez ahí, podrás añadir la dirección en la que desees recibir los pedidos. Además, podrás añadir más de una dirección, teniendo una como tu favorita.</p>
            <p>Aunque puedes añadir más de una dirección, en <strong>Books</strong> sólo se permite un máximo de <strong>3</strong> direcciones, por lo que, si no te deja añadir una nueva dirección es porque ya has llegado al máximo de direcciones permitidas.</p>
            <p>Para añadir una nueva dirección, puedes eliminar alguna que ya no necesites y añadir la nueva dirección.</p>
            <p>Esperamos que te haya servido de ayuda.</p>
        </div>
    </div>
</div>
@endsection    