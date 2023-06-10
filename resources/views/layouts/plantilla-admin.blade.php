<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield("title")</title>
    <link rel="shortcut icon" href="{{asset('uploads/logo.ico')}}" type="image/x-icon">
    <script src="{{asset('build/assets/jquery-3.6.3.min.js')}}"></script>
    <script src="{{asset('build/assets/moment.min.js')}}"></script>
    @livewireStyles
    @vite(["resources/css/app.scss","resources/js/color-theme.js", "resources/js/app.js", "resources/js/validation_form.js", "resources/js/color-theme.js"])
</head>
<body>
    <input type="checkbox" name="" id="toggler-sidebar">
    <div class="sidebar">
        <!-- Sidebar header -->
        <div class="sidebar-header py-3">
            <figure class="m-0 text-center">
                <img src="{{asset('uploads/logo-nombre2.svg')}}" alt="Logo" class="img-fluid">
            </figure>
            <div data-bs-theme="dark">
                <label for="toggler-sidebar"><i class="btn btn-close"></i></label>
            </div>

        </div>
        <!-- Sidebar body -->
        <div class="sidebar-body text-white">
            <div class="user__info">
                <figure>
                    <img src="{{asset(Auth::user()->avatar)}}" alt="Imagen de perfil" class="img-fluid">
                </figure>
                <div class="user__info__data">
                    <p class="username">{{Auth::user()->username}}</p>
                    <p class="rol">Administrador</p>
                </div>
            </div>
            {{-- <p class="text-center fw-bold">TABLAS</p> --}}
            <ul>
                <li class="py-1 px-2"><a href="{{route('admin.index')}}" class="text-decoration-none d-flex gap-2"><i class="bi bi-speedometer2"></i>Dashboard</a></li>
                <li>
                    <div class="accordion-item">
                        <button class="accordion-button collapsed dropdown-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        <i class="bi bi-table"></i> Tablas
                        </button>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                          <div class="accordion-body">
                            <ul>
                                <li class="py-1 px-2"><a href="{{route('admin.users')}}" class="d-flex gap-2"><i class="bi bi-person-circle"></i>Usuarios</a></li>
                                <li class="py-1 px-2"><a href="{{route('libros.index')}}" class="d-flex gap-2"><i class="bi bi-book"></i>Libros</a></li>
                                <li class="py-1 px-2"><a href="{{route('showAll.orders')}}" class="d-flex gap-2"><i class="bi bi-box-seam"></i>Pedidos</a></li>
                                <li class="py-1 px-2"><a href="{{route('admin.posts')}}" class="d-flex gap-2"><i class="bi bi-chat-left-text"></i>Blog</a></li>
                                <li class="py-1 px-2"><a href="{{route('provincias.show')}}" class="d-flex gap-2"><i class="bi bi-geo-alt-fill"></i>Provincias</a></li>
                            </ul>
                          </div>
                        </div>
                    </div>
                </li>
                <li class="py-1 px-2"><a href="{{route('calendar.show')}}" class="d-flex gap-2 align-items-center"><i class="bi bi-calendar"></i> Calendario</a></li>
                <li class="py-1 px-2"><a href="{{route('index')}}" class="text-decoration-none d-flex gap-2 align-items-center"><i class="bi bi-house-door"></i>Volver a inicio</a></li>
                <li class="d-flex gap-2 py-1 px-2">
                    <form action="{{route('login.logout')}}" method="post">
                        @csrf
                        @method('put')
                        {{-- Cuando haga click en el enlace hará un submit --}}
                        <a href="#" onclick="this.closest('form').submit()"><i class="bi bi-box-arrow-left"></i> Cerrar sesión</a>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    {{-- Contenido --}}
    <div class="main-content">
        <nav class="navbar-admin navbar navbar-expand-lg align-items-center px-5">
            <div class="container-fluid justify-content-between gap-2 gap-lg-0">
                <label for="toggler-sidebar"><i class="bi bi-plus-lg btn-toggler"></i></label>
    
                {{-- USER INFO --}}
                <div id="navbar_menu">
                    <div class="changeMode__container dropdown">
                        <button class="btnTheme dropdown-toggle bg-transparent border-0 text-white" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="theme-icon"></i>
                        </button>
                        <ul class="dropdown-menu">
                          <li class="light-mode theme" data-theme-value="light">
                            <button class="dropdown-item d-flex gap-2">
                              <i class="bi bi-sun"></i>
                              <span>Modo claro</span>
                            </button>
                          </li>
                          <li class="dark-mode theme" data-theme-value="dark">
                            <button class="dropdown-item d-flex gap-2">
                              <i class="bi bi-moon-fill"></i>
                              <span>Modo oscuro</span>
                            </button>
                          </li>
                          <li class="auto-mode theme" data-theme-value="auto">
                            <button class="dropdown-item d-flex gap-2">
                              <i class="bi bi-circle-half"></i>
                              <span>Auto</span>
                            </button>
                          </li>
                        </ul>
                    </div>
                    @if (Auth::check())
                    <div class="user__info">
                        <figure>
                            <img src="{{asset(Auth::user()->avatar)}}" alt="Imagen de perfil" class="img-fluid">
                        </figure>
                        <span class="user__info-username">{{Auth::user()->username}}</span>
                    </div>
                    @endif
                </div>
            </div>
        </nav>
    
    
        <main class="container-fluid flex-grow-1 py-3">
            <div class="row">
                {{-- Alerta si se ha añadido, actualizado o eliminado un usuario --}}
                @if (session("message")) 
                    <div id="alert-success" class="alert alert-success mt-2"><i class="bi bi-check-circle"></i> {{session('message')}}</div>
                @endif
                @if (session('message_error'))
                    <div id="alert-error" class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                      <i class="bi bi-exclamation-circle"></i> 
                      {{session('message_error')}} 
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @yield('content')            
    
            </div>
        </main>
    </div>
    <label for="toggler-sidebar" id="body-label"></label>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/r-2.4.1/datatables.min.js"></script>
    @yield('script')
    @livewireScripts
    <script>
      Livewire.onPageExpired((response, message) => {})
  </script>
</body>
</html>