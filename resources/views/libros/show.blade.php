@extends('layouts.plantilla')
@section("title", "Books | Nombre del libro")
@section("generos_libros")
    @foreach ($generos as $genero)
        <li><a class="dropdown-item" href="{{route('libros.filter', $genero->genero)}}">{{$genero->genero}}</a></li>
    @endforeach
@endsection
@section('content')
{{-- {{$libro}} --}}
    <div class="libro__container py-4">
        <div class="portada__container">
            <figure>
                <img src="{{asset($libro->portada)}}" alt="{{$libro->titulo}}" class="d-block img-fluid">
            </figure>

        </div>
        {{-- INFO DEL LIBRO --}}
        <div class="libro__info">
            <div class="libro__info__header">
                <h2 class="libro__info__titulo">{{$libro->titulo}}</h2>
                <p class="libro__info__autor">{{$libro->autor}}</p>
            </div>

            <div class="libro__info__body">
                <p><strong>Editorial: </strong>{{$libro->editorial}}</p>
                <p><strong>Fecha de publicación: </strong>{{$libro->fecha_publicacion}}</p>
                <p><strong>Género: </strong>{{$libro->genero}}</p>
                <p><strong>Valoración: </strong>{{$libro->valoracion}}/10</p>
                <p><strong>Páginas: </strong>{{$libro->paginas}}</p>
            </div>
        </div>

        {{-- PRECIO Y AÑADIR A CESTA --}}
        <div class="precio__carrito">
            <div class="precio__container">
                <p class="precio">{{$libro->precio}}€</p>
                <small class="iva">IVA incluido</small>
            </div>

            {{-- Si hay stock del libro --}}
            @if ($libro->stock>0) 
                <p class="stock text-success">En stock</p>
                <form action="" method="get" class="form-add-to-cart">
                    @csrf
                    @if (Auth::check()) {{-- Si hay una sesión iniciada --}}
                        <button type="submit" class="boton btn-carrito" data-id="{{$libro->id}}"><i class="bi bi-cart"></i> Añadir a mi cesta</button>
                    @else
                        <button type="submit" class="boton btn-carrito" disabled><i class="bi bi-cart"></i> Añadir a mi cesta</button>
                    @endif
                </form>
                
                {{-- Si no hay stock --}}
                @else
                <p class="stock text-danger">Sin stock</p>
                <button class="boton btn-carrito" disabled><i class="bi bi-cart"></i> Añadir a mi cesta</button>
            @endif

        </div>
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