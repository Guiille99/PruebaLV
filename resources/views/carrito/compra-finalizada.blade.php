@extends('layouts.plantilla')
@section("title", "Compra finalizada")
@section('body-class', 'vh-100 d-flex flex-column justify-content-between')
@section('content')
<div class="container flex-fill">
    <div class="shop-steps-container mt-4 col-11 col-md-8 col-lg-5 m-auto">
        <ul class="m-0 p-0">
            {{-- Step 1 --}}
            <li class="active">
                <div>
                    <div class="step-circle">
                        <span>1</span>
                    </div>
                    <p>Carrito</p>
                </div>
            </li>
            <div class="separator"></div>
            {{-- Step 2 --}}
            <li class="active">
                <div>
                    <div class="step-circle">
                        <span>2</span>
                    </div>
                    <p>Detalles de envío</p>
                </div>
            </li>
            <div class="separator"></div>
            {{-- Step 3 --}}
            <li class="active">
                <div>
                    <div class="step-circle">
                        <span>3</span>
                    </div>
                    <p>Compra finalizada</p>
                </div>
            </li>
        </ul>
    </div>
    
    <div class="compra-finalizada-message__container m-auto col-10 col-md-4 text-center my-4 p-3">
        <i class="bi bi-check-circle"></i>
        <p>Compra finalizada finalizada con éxito</p>
        <a href="{{route('index')}}">Seguir comprando</a>
    </div>

</div>
@endsection
