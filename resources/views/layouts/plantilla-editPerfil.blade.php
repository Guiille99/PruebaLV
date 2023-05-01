@extends('layouts.plantilla')
@section('title', 'Mi Cuenta | Books')
@section('content')
<div class="container">
    <nav class="pt-3" aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('index')}}">Inicio</a></li>
          <li class="breadcrumb-item active" aria-current="page">Mi cuenta</li>
        </ol>
    </nav>

    <div class="account__container d-flex gap-3 pb-4">
        <div class="column menu m-0 p-0">
            <div class="menu-content">
                <ul class="m-0 p-0">
                    <li class="menu-section">
                        <a href="{{route('user.editPerfil', $user)}}" class="section-title @yield('miCuenta-isActive')">
                            <i class="bi bi-person-fill"></i>
                            <span>MI CUENTA</span>
                        </a>
                        <ul class="p-0">
                            <li><a href="{{route('user.editPerfil-datos', $user)}}">Mis Datos</a></li>
                            <li><a href="">Mis Direcciones</a></li>
                            <li><a href="">Contraseña</a></li>
                            <li><a href="">Eliminar Cuenta</a></li>
                        </ul>
                    </li>
                    <li class="menu-section">
                        <a href="" class="section-title @yield('misPedidos-isActive')">
                            <i class="bi bi-journal-text"></i>
                            <span>MIS PEDIDOS</span>
                        </a>
                        <ul class="p-0">
                            <li><a href="">Mis pedidos</a></li>
                            <li><a href="">Pedidos cancelados</a></li>
                        </ul>
                    </li>
                    <li class="menu-section">
                        <a href="" class="section-title @yield('miWishlist-isActive')">
                            <i class="bi bi-heart-fill"></i>
                            <span>MI WISHLIST</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        @yield('content-profile')
    </div>
</div>
@endsection