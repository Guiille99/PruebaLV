@extends('layouts.plantilla')
@section('title', 'Métodos de pago disponibles')
@section('body-class', 'vh-100 d-flex flex-column justify-content-between')
@section('content')
<div class="container flex-grow-1">
    <nav class="pt-3" aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{route('index')}}">Inicio</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{route('support')}}">Ayuda</a></li> 
            <li class="breadcrumb-item active" aria-current="page">¿Cuáles son los métodos de pago disponibles?</li> 
        </ol>
    </nav>
    <div class="info-empresa__container support__container py-3">
        <div class="title__container">
            <h1 class="title">¿Cuáles son los métodos de pago disponibles?</h1>
        </div>
        <div class="support-answer py-3">
            <p>En <strong>Books</strong> existen <strong>3 métodos de pago</strong> con los que podrás realizar tus compras:</p>
            <ul>
                <li>
                    <p class="fw-bold">Tarjeta de crédito</p>
                    <p>Para pagar con tarjeta de crédito simplemente deberás seleccionar la opción <i><strong>Tarjeta de crédito</strong> una vez estés en la sección</i> <i><strong>Detalles de envío</strong></i> del carrito de compra.</p> Una vez seleccionado dicho método, deberás rellenar el número de la tarjeta, el mes y año de caducidad y el CVC. <br><br>
                    <p class="fw-bold">¿Qué es el CVC?</p>
                    <p>El CVC es un código de seguridad que tienen todas las tarjetas. Se encuentra en la parte trasera de la tarjeta, donde habrá una serie de números, el CVC son los tres últimos números de esa serie.</p> 
                </li>
                <li>
                    <p class="fw-bold">Paypal</p>
                    <p>Para pagar con Paypal sólo deberás seleccionar dicha opción antes de finalizar la compra. Una vez seleccionado dicho método y pulsado el botón <i><strong>Realizar pedido</strong></i> se mostrará una ventana en la que deberás poner tu correo y contraseña de Paypal y pulsar el botón <i><strong>Finalizar compra</strong></i>. Una vez hecho esto, la compra habrá sido efectuada correctamente.</p>
                </li>
                <li>
                    <p class="fw-bold">Bizum</p>
                    <p>Para realizar el pedido a través de Bizum se deberá seleccionar dicha opción y colocar el número de teléfono asociado a tu cuenta Bizum en la ventana que saldrá cuando le des a <i><strong>Realizar pedido</strong></i>. Una vez hecho esto, deberás pulsar el botón <i><strong>Finalizar compra</strong></i> y el pago se realizará correctamente.</p>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection    