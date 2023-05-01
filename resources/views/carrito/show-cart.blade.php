@extends('layouts.plantilla')
@section("title", "Carrito")
@if (count((array) session('carrito')) < 2)
@section('body-class', 'vh-100 d-flex flex-column justify-content-between')
    
@endif
    
@section('content')
    <div class="shop-steps-container mt-3 col-11 col-md-8 col-lg-5 m-auto">
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
            <li>
                <div>
                    <div class="step-circle">
                        <span>2</span>
                    </div>
                    <p>Detalles de envío</p>
                </div>
            </li>
            <div class="separator"></div>
            {{-- Step 3 --}}
            <li>
                <div>
                    <div class="step-circle">
                        <span>3</span>
                    </div>
                    <p>Compra finalizada</p>
                </div>
            </li>
        </ul>
    </div>
    <div class="cart-container row py-4 m-auto col-md-12 col-lg-10">
        @if (session()->get('carrito'))
        <div class="productos__carrito col-12 col-md-8 border-end position-relative">
            <form action="{{route('carrito.update')}}" method="post">
                @csrf
                @method("put")
                <div class="table-responsive">
                    <table class="table">
                        <thead class="border-3 border-bottom">
                            <th>PRODUCTO</th>
                            <th>PRECIO</th>
                            <th>CANTIDAD</th>
                            <th>SUBTOTAL</th>
                        </thead>
                        <tbody>
                            @foreach (session()->get('carrito') as $id => $libro)
                            <tr>
                                <td class="d-flex align-items-center gap-3">
                                    <i class="btn-delete-to-cart bi bi-x-circle" data-idlibro="{{$id}}"></i>
                                  <figure>
                                      <img src="{{$libro["portada"]}}" alt="{{$libro["titulo"]}}" class="img-fluid">
                                  </figure>
                                  <p>{{$libro["titulo"]}}</p>
                                </td>
          
                                <td>{{$libro["precio"]}} €</td>
                                <td><input type="number" name="{{$id}}" id="{{$id}}-cantidad" value="{{$libro["cantidad"]}}" min="1" max="{{$libro["stock"]}}" data-idlibro="{{$id}}"></td>
                                <td>{{$libro["precio"]*$libro["cantidad"]}} €</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex flex-column flex-md-row gap-2 gap-md-4">
                    <a href="{{route('index')}}" class="boton text-center"><i class="bi bi-arrow-left"></i> Seguir comprando</a>
                    <input type="submit" value="Actualizar carrito" class="boton">
                </div>
            </form>
        </div>
            
        <div class="col-12 col-md-4 border-start">
            <table class="table">
                <thead class="border-3 border-bottom">
                    <th>Total del carrito</th>
                </thead>
                <tbody>
                    <td><p>Total: <span class="fw-bold">{{session()->get('carrito-data')["total"]}} €</span><span id="iva-message"> (IVA incluido)</span></p> </td>
                </tbody>
                <tfoot>
                    {{-- <td><input type="button" value="Finalizar compra" class="boton"></td> --}}
                    <td><a href="{{route('show-detalles-envio')}}" class="boton">Confirmar compra</a></td>
                </tfoot>
            </table>
        </div>
        @else
            <div class="d-flex flex-column align-items-center">
                <i class="bi bi-cart-x fs-1"></i>
                <h3 class="text-center">No hay productos en la cesta</h3>
            </div>
        @endif
    </div>

@endsection
@section('script')
    <script>
        // $(document).ready(function(){
        //     $('.btn-delete').click(function(){
        //         let url = "{{route('delete_to_cart', 'num')}}";
        //         let id = $(this).attr("data-idlibro");
        //         url = url.replace('num', id);
        //         $.ajaxSetup({
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //             }
        //         });
        //         $.ajax({
        //             async: true,
        //             url: url,
        //             method: "DELETE",
        //             success: function (data) {
        //                 location.reload();
        //                 // $('#alert-index').text(data.message);
        //                 // $('#alert-index').css('display', 'block');
        //             },
        //         });
        //     })
        // })

        let url = "{{route('delete_to_cart', 'num')}}";
    </script>
    @vite(['resources/js/cart.js'])
@endsection