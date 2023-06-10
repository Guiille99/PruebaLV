@extends('layouts.plantilla')
@section('title', 'Cómo cancelar un pedido')
@section('body-class', 'vh-100 d-flex flex-column justify-content-between')
@section('content')
<div class="container flex-grow-1">
    <nav class="pt-3" aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{route('index')}}">Inicio</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{route('support')}}">Ayuda</a></li> 
            <li class="breadcrumb-item active" aria-current="page">¿Cómo puedo cancelar un pedido?</li> 
        </ol>
    </nav>
    <div class="info-empresa__container support__container py-3">
        <div class="title__container">
            <h1 class="title">¿Cómo puedo cancelar un pedido?</h1>
        </div>
        <div class="support-answer py-3">
            <p>En <i><strong>Books</strong></i> podrás cancelar tus pedidos de forma rápida y sencilla. Para ello, deberás seguir los siguientes pasos:</p>
            <ol>
                <li>
                    <p>Deberás pulsar tu nombre de perfil en la parte superior de la página y dirigirte a <i><strong>Perfil > Mis pedidos </strong>(Situado en el menú)</i>.</p>
                </li>
                <li>
                    <p>Una vez dentro, de <i><strong>Mis pedidos</strong></i> te aparecerán una lista con todos los pedidos que has realizado en <strong>Books</strong>. Aquellos que se encuentren en la fase de <strong>Pre-admisión</strong> podrán ser cancelados pulsando el botón <i><strong>Cancelar</strong></i> situado a la derecha del pedido</p>
                </li>
            </ol>
        </div>
    </div>
</div>
@endsection    