<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("title")</title>
    <link rel="shortcut icon" href="{{asset('uploads/logo.ico')}}" type="image/x-icon">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous"> --}}
    @vite(["resources/css/app.scss", "resources/js/jquery-3.6.3.js", "resources/js/app.js", "resources/js/font-awesome.js", "resources/js/validation_form.js"])
</head>
<body class="@yield('body-class')">
    <header>
      <div class="nav-top container-fluid">
        <div class="row bg-success align-items-center d-none d-lg-flex">
          <div class="col-3">
            <figure class="m-0">
              <a href="{{ route('index')}}"><img src="{{asset('uploads/logo-nombre2.svg')}}" alt="LOGO" class="img-fluid"></a>
            </figure>
          </div>
          <div class="col">
            <form action="{{ route('libros.getFiltro')}}" method="post" >
              @csrf
              <div class="input-group">
                <i class="bi bi-search input-group-text"></i>
                <input type="text" name="filtro" id="filtroLibro" class="form-control" placeholder="Buscar">
              </div>
              <button type="submit" class="d-none"></button>
            </form>
          </div>
          <div class="cuenta-carrito col-3 d-flex justify-content-center gap-4">
            <div class="login__container"> {{-- LOGIN CONTAINER --}}
              {{-- Si se ha iniciado sesión --}}
              @if (Auth::check())
                <div class="dropdown">
                  <a class="username dropdown-toggle text-decoration-none" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person"></i> <span>{{Auth::user()->username}}</span>
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{route('user.editPerfil', Auth::user())}}"><i class="bi bi-person-gear"></i> Perfil</a></li>
                    @if (Auth::user()->rol=="Administrador")
                    <li><a class="dropdown-item" href="{{route('admin.index')}}"><i class="bi bi-tools"></i> Panel Administración</a></li>
                    @endif
                    <li>
                      <form action="{{route('login.logout')}}" method="post">
                        @method('put')
                        @csrf
                        {{-- Cuando haga click en el enlace hará un submit --}}
                        <a class="dropdown-item" href="#" onclick="this.closest('form').submit()"><i class="bi bi-box-arrow-left"></i> Cerrar sesión</a></li>
                      </form>
                  </ul>
                </div>
  
              @else
                <a href="{{route('login')}}" class="nav-link login-link">
                  {{-- <img src="{{asset('uploads/person.svg')}}" alt="Mi cuenta" class="img-fluid"> --}}
                  <span>Iniciar Sesión</span>
                </a>
              @endif
            </div>

            @if (!Auth::check()) {{-- Si no se ha iniciado sesión --}}
            <div class="register__container"> {{-- REGISTER CONTAINER --}}
              <a href="{{route('register.index')}}" class="nav-link register-link">
                {{-- <img src="{{asset('uploads/person.svg')}}" alt="Mi cuenta" class="img-fluid"> --}}
                <span>@yield("miCuenta")Regístrate</span>
              </a>
            </div>
            @endif
    
            @if (Auth::check())
            <div class="carrito__container">
              <a href="" class="nav-link">
                <img src="{{asset('uploads/cart.svg')}}" alt="Carrito" class="img-fluid">
                <span class="carrito__cantidad">0</span>
              </a>
            </div>
            @endif
          </div>
        </div>
      </div>
    

      {{-- SUB-NAV --}}
      <nav class="down-nav navbar navbar-expand-lg text-center pb-3 p-md-2">
        <div class="container-fluid">      
          <a class="navbar-brand d-block d-lg-none" href="{{ route('index')}}">
            <img src="{{asset('uploads/logo-nombre2.svg')}}" alt="LOGO">
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <img src="{{asset('uploads/toggler.svg')}}" alt="Toggler button" class="toggler__button">
          </button>
          <div class="collapse navbar-collapse justify-content-center gap-5" id="navbarNav">
            {{-- Nav items --}}
            <ul class="nav__options navbar-nav gap-2 gap-lg-4 justify-content-center">
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="{{ route('index')}}">Inicio</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Libros
                </a>
                <ul class="dropdown-menu">

                  {{-- @yield('generos_libros') --}}
                  @foreach ($generos as $genero)
                  <li><a class="dropdown-item" href="{{route('libros.filter', $genero->genero)}}">{{$genero->genero}}</a></li>
                  @endforeach
                  
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{route('libros.filter', 'novedades')}}">Novedades</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{route('blog')}}">Blog</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{route('contacto')}}">Contacto</a>
              </li>
            </ul>
    
            <form action="{{ route('libros.getFiltro')}}" method="post" class="d-block d-lg-none mt-2">
              @csrf
              <div class="input-group">
                <i class="bi bi-search input-group-text"></i>
                <input type="text" name="filtro" id="filtroLibro" class="form-control" placeholder="Buscar">
              </div>
              <button type="submit" class="d-none"></button>
            </form>
    
            <div class="cuenta-carrito d-flex justify-content-center gap-4 mt-3 d-block d-lg-none">
              <div class="login__container"> {{-- LOGIN CONTAINER --}}
                {{-- Si se ha iniciado sesión --}}
                @if (Auth::check()) 
                <div class="dropdown">
                  <a class="username dropdown-toggle text-decoration-none" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person"></i> <span>{{Auth::user()->username}}</span>
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{route('user.editPerfil', Auth::user())}}"><i class="bi bi-person-gear"></i> Perfil</a></li>
                    @if (Auth::user()->rol=="Administrador")
                    <li><a class="dropdown-item" href="{{route('admin.index')}}"><i class="bi bi-tools"></i> Panel Administración</a></li>
                    @endif
                    <li>
                      <form action="{{route('login.logout')}}" method="post">
                        @method('put')
                        @csrf
                        {{-- Cuando haga click en el enlace hará un submit --}}
                        <a class="dropdown-item" href="#" onclick="this.closest('form').submit()"><i class="bi bi-box-arrow-left"></i> Cerrar sesión</a></li>
                      </form>
                  </ul>
                </div>
  
                @else
                  <a href="{{route('login')}}" class="nav-link login-link">
                    {{-- <img src="{{asset('uploads/person.svg')}}" alt="Mi cuenta" class="img-fluid"> --}}
                    <span>Iniciar Sesión</span>
                  </a>
                @endif
              </div>

              @if (!Auth::check()) {{-- Si no se ha iniciado sesión --}}
                <div class="register__container"> {{-- REGISTER CONTAINER --}}
                  <a href="{{route('register.index')}}" class="nav-link register-link">
                    <span>@yield("miCuenta")Regístrate</span>
                  </a>
                </div>
              @endif
              
              @if (Auth::check())
              <div class="carrito__container">
                <a href="" class="nav-link">
                  <img src="{{asset('uploads/cart.svg')}}" alt="Carrito" class="img-fluid">
                  <span class="carrito__cantidad">0</span>
                </a>
              </div>
              @endif
            </div>
          </div>
        </div>
      </nav>
    </header>


    @yield('content')






    {{-- FOOTER --}}
    <footer class="@yield('footer-class')">
      <figure>
        <picture>
          <source media="(min-width: 768px)" srcset="{{asset('uploads/logo-xl.png')}}">
          <img src="{{asset('uploads/logo.png')}}" alt="Logo" class="img-fluid">
        </picture>
      </figure>

      <div class="info__container">
        <div class="footer__menu__container">
          <div class="footer__menu">
            <h4>Contacto</h4>
            <div class="info__details">
              <p><i class="bi bi-telephone-fill"></i> 623456789</p>
              <p><i class="bi bi-geo-alt-fill"></i> Sevilla (España)</p>
              <a href="mailto:info@carpinteriamaderareal@gmail.com"><i class="bi bi-envelope-fill"></i> info@book.com</a>
            </div>
          </div>

          <div class="footer__menu">
            <h4>Información legal</h4>
            <div class="info__details">
              <a href="">Condiciones de uso</a>
              <a href="">Política de protección de datos</a>
              <a href="">Política de cookies</a>
              <a href="">Condiciones para vender</a>
            </div>
          </div>

          <div class="footer__menu">
            <h4>Otros enlaces</h4>
            <div class="info__details">
              <a href="">Mapa del sitio</a>
              <a href="">Empleo</a>
              <a href="">Quiénes somos</a>
            </div>
          </div>


        </div>

        <div class="rrss__container">
          <a href=""><i class="fa-brands fa-facebook-f"></i></a>
          <a href=""><i class="bi bi-instagram"></i></a>
          <a href=""><i class="bi bi-twitter"></i></a>
          <a href=""><i class="bi bi-linkedin"></i></a>
        </div>
      </div>
    </footer>
</body>
</html>