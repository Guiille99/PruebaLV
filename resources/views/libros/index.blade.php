@extends('layouts.plantilla')
@section("title", "Books | Listado")
{{-- @section("generos_libros")
    @foreach ($generos as $genero)
        <li><a class="dropdown-item" href="{{route('libros.filter', $genero->genero)}}">{{$genero->genero}}</a></li>
    @endforeach
@endsection --}}

@section('content')

    @if (count($libros)==0)
    @section('body-class', 'd-flex flex-column justify-content-between vh-100')

    <h1 class="text-center fw-bold p-5 p-md-0">No se ha encontrado ningún artículo :(</h1>
    @else

    <div class="container-fluid mt-5">
        <div class="row mt-5">
            <div class="title__container">
                @if ($filtro=="novedades")
                    <h1 class="text-center">Libros más recientes</h1>
                @else
                    <h1 class="text-center">Libros de {{$filtro}}</h1>
                @endif
            </div>
            <div class="recomendados__container col-6 col-md-10 m-auto">
                <div class="libros__container mt-3">
                    @foreach ($libros as $libro)
                    <div class="card">
                        <figure class="m-0">
                           <a href="{{route('libros.show', $libro)}}"><img src="{{asset($libro->portada)}}" alt="{{$libro->titulo}}" class="img-fluid"></a> 
                        </figure>
                        <div class="libro__info">
                            <h4 class="libro__titulo" title="{{$libro->titulo}}">{{$libro->titulo}}</h4>
                            <p class="libro__autor">{{$libro->autor}}</p>
                            <p class="libro__precio">{{$libro->precio}}€</p>
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
                <div class="my-3">
                    {{$libros->links()}}
                </div>
                
            </div>
        </div>
    </div>
    @endif
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