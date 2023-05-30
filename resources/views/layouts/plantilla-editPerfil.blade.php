@extends('layouts.plantilla')
@section('title', 'Mi Cuenta | Books')
@section('content')
<div class="container">
    <nav class="pt-3" aria-label="breadcrumb">
        <ol class="breadcrumb">
          @yield('breadcrumb-profile')
        </ol>
    </nav>

    <div id="message_error">
        
    </div>
    <div class="account__container">
        <nav class="navbar navbar-expand-lg navbarMenuPerfil align-items-start" data-bs-theme="dark">
            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMenu" aria-controls="collapseMenu" aria-expanded="false" aria-label="Menú del perfil">
                    <img src="{{asset('uploads/toggler.svg')}}" alt="Toggler button" class="toggler-button">
                </button>
                <span class="d-lg-none navbar-brand">MENÚ</span>
            </div>
            <div id="collapseMenu" class="collapse navbar-collapse">
                <div class="column menu m-0 p-0">
                    <div class="menu-content">
                        <ul class="m-0 p-0">
                            <li class="menu-section">
                                <a href="{{route('user.editPerfil', Auth::user())}}" class="section-title @yield('miCuenta-isActive')">
                                    <i class="bi bi-person-fill"></i>
                                    <span>MI CUENTA</span>
                                </a>
                                <ul class="p-0">
                                    <li><a href="{{route('user.editPerfil-datos', Auth::user())}}">Mis Datos</a></li>
                                    <li><a href="{{route('user.editPerfil-direcciones', Auth::user())}}">Mis Direcciones</a></li>
                                    <li><a href="{{route('user.editPerfil-password', Auth::user())}}">Contraseña</a></li>
                                    <li><a href="{{route('newsletter.destroy-view', Auth::user())}}">Desuscribirse de Newsletter</a></li>
                                    <li><a href="{{route('user.destroy-view', Auth::user())}}">Eliminar Cuenta</a></li>
                                </ul>
                            </li>
                            <li class="menu-section">
                                <a href="{{route('show.orders')}}" class="section-title @yield('misPedidos-isActive')">
                                    <i class="bi bi-journal-text"></i>
                                    <span>MIS PEDIDOS</span>
                                </a>
                                <ul class="p-0">
                                    <li><a href="{{route('show.orders')}}">Mis pedidos</a></li>
                                    <li><a href="{{route('show.cancelOrders')}}">Pedidos cancelados</a></li>
                                </ul>
                            </li>
                            <li class="menu-section">
                                <a href="{{route('show.wishlist')}}" class="section-title @yield('miWishlist-isActive')">
                                    <i class="bi bi-heart-fill"></i>
                                    <span>MI WISHLIST</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        @yield('content-profile')
    </div>
</div>
@endsection