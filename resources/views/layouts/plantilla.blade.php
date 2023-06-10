<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield("title")</title>
    <link rel="shortcut icon" href="{{asset('uploads/logo.ico')}}" type="image/x-icon">
    <script src="{{asset('build/assets/jquery-3.6.3.min.js')}}"></script>
    @livewireStyles
    @vite(["resources/css/app.scss","resources/js/color-theme.js", "resources/js/app.js", "resources/js/validation_form.js"])
</head>
<body class="@yield('body-class')">
    <header>
      {{-- TOP-NAV --}}
      <div class="nav-top container-fluid">
        <div class="row bg-success align-items-center d-none d-lg-flex position-relative">
          <div class="col-2">
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
          <div class="cuenta-carrito col-4 d-flex justify-content-center align-items-center gap-4">
            {{-- Dropdown screen mode --}}
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
            

            <div class="login__container"> {{-- LOGIN CONTAINER --}}
              {{-- Si se ha iniciado sesión --}}
              @if (Auth::check())
                <div class="dropdown">
                  <div class="username dropdown-toggle d-flex align-items-center gap-2 text-decoration-none" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{-- <i class="bi bi-person"></i>  --}}
                    <figure class="m-0">
                      <img src="{{asset(Auth::user()->avatar)}}" alt="Imagen de perfil" class="img-fluid">
                    </figure>
                    <span>{{Auth::user()->username}}</span>
                  </div>
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
                        <a class="dropdown-item" href="#" onclick="this.closest('form').submit()"><i class="bi bi-box-arrow-left"></i> Cerrar sesión</a>
                      </form>
                    </li>
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
              <a href="" class="nav-link" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCarrito" aria-controls="offcanvasRight">
                <img src="{{asset('uploads/cart.svg')}}" alt="Carrito" class="img-fluid">
                @if (Auth::user()->carrito != null)
                  <span class="carrito__cantidad">{{Auth::user()->carrito->items->sum('cantidad')}}</span>
                {{-- <span class="carrito__cantidad">{{session('carrito-data')["cantidad"]}}</span> --}}
                @else
                  <span class="carrito__cantidad">0</span>
                @endif
              </a>
            </div>
            @livewire('wishlist-component-icon')
            @endif
          </div>
        </div>
      </div>
    
      {{-- SUB-NAV --}}
      <nav class="down-nav navbar navbar-expand-lg text-center pb-3 p-md-2">
        <div class="container-fluid">      
          <a class="navbar-brand d-block d-lg-none" href="{{ route('index')}}">
            <picture>
              <source media="(max-width: 375px)" srcset="{{asset('uploads/logo.png')}}">
              <img src="{{asset('uploads/logo-nombre2.svg')}}" alt="LOGO" class="img-fluid">
            </picture>
          </a>

          <div class="d-flex gap-4">
            {{-- Carrito --}}
            @if (Auth::check())
            <div class="carrito__container d-block d-lg-none">
              <a href="" class="nav-link" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCarrito" aria-controls="offcanvasRight">
                <img src="{{asset('uploads/cart.svg')}}" alt="Carrito" class="img-fluid">
                @if (Auth::user()->carrito != null)
                <span class="carrito__cantidad">{{Auth::user()->carrito->items->sum('cantidad')}}</span>
                @else
                <span class="carrito__cantidad">0</span>
                @endif
              </a>
            </div>
            @livewire('wishlist-component-icon')
            @endif
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <img src="{{asset('uploads/toggler.svg')}}" alt="Toggler button" class="toggler__button">
            </button>
          </div>

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
    
            <div class="cuenta-carrito d-flex align-items-center justify-content-center gap-4 mt-3 d-block d-lg-none">
              {{-- Dropdown screen mode --}}
              <div class="changeMode__container" class="dropdown">
                <button class="btnTheme dropdown-toggle bg-transparent border-0 text-white" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="theme-icon"></i>
                </button>
                <ul class="dropdown-menu left-auto">
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

              <div class="login__container"> {{-- LOGIN CONTAINER --}}
                {{-- Si se ha iniciado sesión --}}
                @if (Auth::check()) 
                <div class="dropdown">
                  <div class="username dropdown-toggle d-flex align-items-center gap-2 text-decoration-none" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <figure class="m-0">
                      <img src="{{asset(Auth::user()->avatar)}}" alt="Imagen de perfil" class="img-fluid">
                    </figure> 
                    <span>{{Auth::user()->username}}</span>
                  </div>
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
                  
            </div>
          </div>
        </div>
      </nav>

    </header>

    {{-- Mensaje cuando añades un libro al carrito --}}
    <div id="add-to-cart__message">
      <p class="m-0">Has añadido el libro a tu cesta</p>
      <i class="bi bi-cart-check-fill"></i>
    </div>

    {{-- Offcanvas carrito --}}
    @if (Auth::check())
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCarrito" aria-labelledby="offcanvasCart">
      <div class="offcanvas-header">
        <button type="button" class="bi bi-x" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        
        <div class="m-auto d-flex justify-content-center align-items-center gap-3">
          <i class="bi bi-bag">
            @if (Auth::user()->carrito != null)
              <span class="carrito__cantidad">{{Auth::user()->carrito->items->sum('cantidad')}}</span>
            {{-- <span class="carrito__cantidad">{{session('carrito-data')['cantidad']}}</span> --}}
            @else
            <span class="carrito__cantidad">0</span>
            @endif
          </i>
          <h5 class="offcanvas-title" id="offcanvasCart">Mi carrito</h5>
        </div>
      </div>
      <div class="offcanvas-content d-flex flex-column flex-grow-1">
        @if (Auth::user()->carrito != null && Auth::user()->carrito->items->count() > 0)
        <div class="offcanvas-body">
            @foreach (Auth::user()->carrito->items as $item)
                <div class="cart-book">
                  <figure>
                    <img src="{{asset($item->libro->portada)}}" alt="portada" class="img-fluid">
                  </figure>
  
                  <div class="book-data">
                    <p>{{$item->libro->titulo}}</p>
                    <div class="book-data__body">
                      <p>{{$item->cantidad}} x <span class="fw-bold">{{$item->libro->precio}}€</span></p>
                    </div>
                    <div class="book-data__footer">
                      <p class="total-unidad">{{$item->libro->precio * $item->cantidad}}€</p>
                      <form action="{{route('delete_to_cart', $item->libro->id)}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="bi bi-trash3 bg-transparent border-0"></button>
                      </form>
                    </div>
                  </div>
                </div>
                @endforeach
          @else
              <div class="offcanvas-body d-flex align-items-center justify-content-center">
                <div class="text-center">
                  <i class="bi bi-emoji-frown"></i>
                  <p>El carrito está vacío</p>
                </div>
          @endif
        </div>
        @if (Auth::user()->carrito!=null && Auth::user()->carrito->items->count() > 0)
        <div class="offcanvas-footer">
          <p id="total">Total: <span class="precio">{{Auth::user()->carrito->items->sum('subtotal')}}€</span></p>
          <a href="{{route('show-cart')}}" class="text-center text-decoration-none">Ver carrito</a>
          <form action="{{route('vaciar-carrito')}}" method="post">
            @csrf
            @method('delete')
            <input type="submit" class="w-100" value="Vaciar cesta">
          </form>
        </div>
        @endif
      </div>

    </div>
    @endif
    @if (session('message'))
        <div id="alert-index" class="alert alert-success"><i class="bi bi-check-circle"></i> {{session('message')}}</div>
    @endif

    @if (session()->has('message_error'))
      <div id="alert-error" class="alert alert-danger alert-dismissible fade show my-2" role="alert">
        <i class="bi bi-exclamation-circle"></i> 
        {{session('message_error')}} 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    
    <button id="btnBack"><i class="bi bi-chevron-up"></i></button>
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
              <a href="mailto:books2023.info@gmail.com"><i class="bi bi-envelope-fill"></i> books2023.info@gmail.com</a>
            </div>
          </div>

          <div class="footer__menu">
            <h4>Información legal</h4>
            <div class="info__details">
              <a href="{{route('condiciones-uso')}}">Condiciones de uso</a>
              <a href="{{route('proteccion-datos')}}">Política de protección de datos</a>
              <a href="{{route('politica-cookies')}}">Política de cookies</a>
            </div>
          </div>

          <div class="footer__menu">
            <h4>Otros enlaces</h4>
            <div class="info__details">
              <a href="{{route('newsletter.destroy-no-account-view')}}">Baja del Newsletter</a>
              <a href="{{route('support')}}">Ayuda</a>
              <a href="{{route('quienes-somos')}}">Quiénes somos</a>
            </div>
          </div>


        </div>

        <div class="rrss__container">
          <a href="https://es-es.facebook.com/"><i class="bi bi-facebook"></i></a>
          <a href="https://www.instagram.com/"><i class="bi bi-instagram"></i></a>
          <a href="https://twitter.com/?lang=es"><i class="bi bi-twitter"></i></a>
          <a href="https://www.linkedin.com/"><i class="bi bi-linkedin"></i></a>
        </div>
      </div>
    </footer>
    @livewireScripts
    <script>
      Livewire.onPageExpired((response, message) => {})
  </script>
</body>
@yield('script')
</html>