@extends('layouts.plantilla')
@section('title', 'Estado del pedido')
@section('body-class', 'vh-100 d-flex flex-column justify-content-between')
@section('content')
<div class="container flex-grow-1">
    <nav class="pt-3" aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{route('index')}}">Inicio</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{route('support')}}">Ayuda</a></li> 
            <li class="breadcrumb-item active" aria-current="page">¿Cómo puedo saber el estado de mi pedido?</li> 
        </ol>
    </nav>
    <div class="info-empresa__container support__container py-3">
        <div class="title__container">
            <h1 class="title">¿Cómo puedo saber el estado de mi pedido?</h1>
        </div>
        <div class="support-answer py-3">
            <p>Usted podrá ver el estado de su pedido en todo momento de manera sencilla. Para ello debe realizar los siguientes pasos:</p>
            <ol>
                <li>Debe hacer click en su nombre de usuario.</li>
                <li>En el menú desplegable que se abrirá, deberá hacer click en <strong><i>Perfil</i></strong>.</li>
                <li>Una vez dentro, deberá dirigirse a la sección <strong><i>Mis pedidos</i></strong>.</li>
            </ol>
            <p>En dicha sección podrá ver todos los pedidos que ha realizado, incluido los pedidos que ha cancelado.</p>
        </div>
    </div>
</div>
@endsection    