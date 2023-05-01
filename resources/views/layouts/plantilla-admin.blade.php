<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("title")</title>
    <link rel="shortcut icon" href="{{asset('uploads/logo.ico')}}" type="image/x-icon">
    <script src="{{asset('build/assets/jquery-3.6.3.js')}}"></script>
    <link rel="stylesheet" href="{{asset('vendor/datatables/css/_datatables.min.css')}}">
    {{-- <script src="{{asset('build/assets/moment.min.js')}}"></script> --}}
    @vite(["resources/css/app.scss", "resources/js/app.js", "resources/js/font-awesome.js", "resources/js/validation_form.js"])
</head>
<body>
        <nav class="navbar-admin navbar navbar-expand-lg align-items-center px-5">
            <div class="container-fluid justify-content-around">
                <button id="toggler-sidebar" class="border-0 fs-2 toggler-admin" type="button" data-bs-toggle="offcanvas" data-bs-target="#navegacion">
                    <i class="bi bi-plus-lg"></i>
                </button>
    
                <figure class="my-0 mx-auto">
                    <a href="{{ route('admin.index')}}"><img src="{{asset('uploads/logo-nombre2.svg')}}" alt="LOGO" class="img-fluid"></a>
                    </figure>
                    {{-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar_menu" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button> --}}
    
                    {{-- USER INFO --}}
                    <div id="navbar_menu">
                        @if (Auth::check())
                        <p class="m-0 text-white"><i class="bi bi-person"></i> {{Auth::user()->username}}</p>
                        @endif
                    </div>
            </div>
        </nav>

        <main class="container-fluid flex-grow-1">
            <div class="row h-100">
                {{-- <div id="sidebar__container"> --}}
                    <!-- navegación -->
                    
                
    
                @yield('content')
    
            </div>
        </main>

    <script src="{{asset('../vendor/datatables/js/datatables.min.js')}}"></script>
    <script src="{{asset('../vendor/datatables/js/moment.min.js')}}"></script>
    @yield('script')
</body>
</html>