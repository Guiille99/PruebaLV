@extends('layouts.plantilla')
@section("title", "Books | Inicio")
@section('content')
    {{-- @if (session('message'))
        <div id="alert-index" class="alert alert-success"><i class="bi bi-check-circle"></i> {{session('message')}}</div>
    @endif --}}

    <div id="carrusel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carrusel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carrusel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carrusel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
            <img src="uploads/carrusel1.jpg" class="d-block w-100" alt="Imagen del carrusel">
            <div class="h-100 w-100 position-absolute d-none d-md-grid top-0 start-0 align-items-center justify-content-center">
                <div class="carousel-caption">
                    <h1>¡Bienvenido a Books!</h1>
                    <p>Disfruta de los mejores libros al mejor precio.</p>
                </div>
            </div>
            </div>
            <div class="carousel-item">
            <img src="uploads/carrusel2.jpg" class="d-block w-100" alt="Imagen del carrusel">
            </div>
            <div class="carousel-item">
            <img src="uploads/carrusel3.jpg" class="d-block w-100" alt="Imagen del carrusel">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carrusel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carrusel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    
    <main class="container-xl">
        {{-- LIBROS RECOMENDADOS --}}
        <div class="row mt-5">
            <div class="title__container">
                <h1 class="text-center">Recomendados</h1>
            </div>
            <div class="recomendados__container col-6 col-md-10 m-auto py-3">
                <div class="libros__container mt-3">
                    @foreach ($libros_recomendados as $libro)
                    <div class="card">
                        <figure class="m-0">
                           <a href="{{route('libros.show', $libro)}}"><img src="{{$libro->portada}}" alt="{{$libro->titulo}}" class="img-fluid"></a>  
                        </figure>
                        <div class="libro__info">
                            <h4 class="libro__titulo" title="{{$libro->titulo}}">{{$libro->titulo}}</h4>
                            <p class="libro__autor">{{$libro->autor}}</p>
                            <p class="libro__precio">{{$libro->precio}}€</p>
                            {{-- <button class="boton">Comprar</button> --}}
                            @if ($libro->stock>0)
                            <form action="{{--{{route('add_to_cart', $libro)}}--}}" method="get" class="form-add-to-cart">
                                @csrf
                                @if (Auth::check()) {{-- Si hay una sesión iniciada --}}
                                    <input type="submit" value="Comprar" class="boton" data-id="{{$libro->id}}">
                                 @else
                                    <input type="submit" value="Comprar" class="boton" disabled>
                                @endif
                            </form>
                            @else
                            <span class="btn-delete">Fuera de Stock</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                
                </div> 
                
            </div>
        </div>

        {{-- LIBROS MÁS RECIENTES --}}
        <div class="row mt-5">
            <div class="title__container">
                <h1 class="text-center">Más recientes</h1>
            </div>
            <div class="recomendados__container col-6 col-md-10 m-auto py-3">
                <div class="libros__container mt-3">
                    @foreach ($libros_recientes as $libro)
                    <div class="card">
                        <figure class="m-0">
                            <a href="{{route('libros.show', $libro)}}"><img src="{{$libro->portada}}" alt="{{$libro->titulo}}" class="img-fluid"></a> 
                        </figure>
                        <div class="libro__info">
                            <h4 class="libro__titulo" title="{{$libro->titulo}}">{{$libro->titulo}}</h4>
                            <p class="libro__autor">{{$libro->autor}}</p>
                            <p class="libro__precio">{{$libro->precio}}€</p>
                            {{-- <button>Comprar</button> --}}
                            @if ($libro->stock>0)
                            <form action="" method="get" class="form-add-to-cart">
                                @csrf
                                @if (Auth::check()) {{-- Si hay una sesión iniciada --}}
                                    <input type="submit" value="Comprar" class="boton" data-id="{{$libro->id}}">
                                 @else
                                    <input type="submit" value="Comprar" class="boton" disabled>
                                @endif
                            </form>
                            @else
                            <span class="btn-delete">Fuera de Stock</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div> 
            </div>
        </div>
    </main>

    {{-- SUSCRIBE SECTION --}}
    <div class="container-fluid">
        <section class="row mt-5">
            <div class="col suscribe__container" style="background-image: url({{asset('uploads/seccion-suscribe.jpg')}});">
                <div class="suscribe__info">
                    <h2 class="suscribe__title">Suscríbete para conocer nuestras últimas noticas</h2>
                    <form action="{{ route('enviar-correo') }}" method="POST">
                        @csrf
                        <input type="email" name="mail" id="mail" class="form-control" placeholder="Introduce tu email">
                        <input type="submit" value="Suscribirse">
                    </form>
                </div>
            </div>
        </section>

        {{-- VENTAJAS --}}
        <section class="row py-5">
            <div class="col-10 col-md-9 ventajas__container">
                <div class="ventaja">
                    <i class="bi bi-bag-check"></i>
                    {{-- <figure>
                        <img src="uploads/bag-check.svg" alt="Compra segura" class="img-fluid">
                    </figure> --}}
                    <p>Compra segura</p>
                </div>

                <div class="ventaja">
                    <i class="bi bi-truck"></i>
                    <p>Envío gratis a partir de 15€</p>
                </div>

                <div class="ventaja">
                    <i class="bi bi-shop"></i>
                    <p>Recogida en tienda gratis</p>
                </div>

                <div class="ventaja">
                    <i class="bi bi-arrow-clockwise"></i>
                    <p>Devolución gratis hasta 30 días</p>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
{{-- <script>
    $(document).ready(function(){
   
        $(".form-add-to-cart").submit(function(e){
            e.preventDefault();
            let url = "{{route('add_to_cart')}}";
            let id = $(this)[0][1].attributes['data-id'].value; //ID del libro
            let token = $("input[name='_token']").val();
  
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
                async: true, //Indica si la comunicación será asincrónica (true)
                method: "POST", //Indica el método que se envían los datos (GET o POST)
                dataType: "html", //Indica el tipo de datos que se va a recuperar
                contentType: "application/x-www-form-urlencoded", //cómo se
                url: url, //el nombre de la página que procesará la petición
                data: {
                    "token": token,
                    "id": id
                },
                success: function(){
                    $(".carrito__cantidad").load("{{route('cantidadCarrito')}}"); //Actualizamos solo el número del carrito
                    // location.reload();
                    $('#add-to-cart__message').css("display", "block");
                    //Obtenemos de nuevo el contenido del carrito a través de AJAX para que se actualice el offcanvas sin recargar la página
                    $.ajax({
                        type: "GET",
                        url: "{{route('offcanvas-cart-content')}}",
                        data:{
                            "token": token
                        },
                        success: function(data){
                            $(".offcanvas-content").html(data);
                        }
                    })
                    
                    setTimeout(function(){ //Degradado al desaparecer la alerta
                         $("#add-to-cart__message").fadeOut(2000);
                    }, 3000)
  
                }
                });
             return false;
        });
    })
  </script> --}}
  <script>
        //Definición de rutas
        let url = "{{route('add_to_cart')}}";
        let urlCartContent = "{{route('offcanvas-cart-content')}}";
        let urlCantidadCarrito = "{{route('cantidadCarrito')}}";
  </script>
      @vite(['resources/js/cart.js'])
  {{-- <script src="{{asset('build/assets/cart.js')}}"></script> --}}
@endsection