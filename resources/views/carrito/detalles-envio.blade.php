@extends('layouts.plantilla')
@section("title", "Detalles de envío")
@section('content')
<div class="shop-steps-container mt-4 col-11 col-md-8 col-lg-5 m-auto">
    <ul class="m-0 p-0">
        {{-- Step 1 --}}
        <li class="active">
            <a href="{{route('show-cart')}}">
                <div class="step-circle">
                    <span>1</span>
                </div>
                <p>Carrito</p>
            </a>
        </li>
        <div class="separator"></div>
        {{-- Step 2 --}}
        <li class="active">
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
<form action="{{route('compra-finalizada')}}" class="needs-validation m-0 p-0" id="form-detalles-pago" method="POST">
    @csrf
    <div class="detalle-pago__container col-lg-10 row m-auto py-4 d-flex gap-5 justify-content-center">
        <div class="col-md-5 row">
            <p class="fw-bold" id="title">Detalles de facturación</p>
            <div class="mt-2 d-flex flex-column col-6">
                <label for="nombre" class="form-label">Nombre *</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{Auth::user()->nombre}}" required>
            </div>

            <div class="mt-2 d-flex flex-column col-6">
                <label for="nombre" class="form-label">Apellidos *</label>
                <input type="text" name="apellidos" id="apellidos" class="form-control" value="{{Auth::user()->apellidos}}" required>
            </div>

            <div class="mt-2 d-flex flex-column">
                <label for="nombre" class="form-label">Correo electrónico *</label>
                <input type="email" name="correo" id="correo" class="form-control" value="{{Auth::user()->email}}" required>
            </div>
            
            {{-- {{Auth::user()->direcciones}} --}}
            <div class="mt-2">
                <label for="direccion" class="form-label">Dirección *</label>
                <select name="direccion" id="direccion" class="col-12 form-select" required>
                    @foreach (Auth::user()->direcciones as $direccion)
                        @if ($direccion->id == Auth::user()->getDireccionPrincipal()->id)
                        <option value="{{$direccion->id}}" selected>{{$direccion->calle}}, {{$direccion->numero}} - {{$direccion->cp}}, {{$direccion->provincia->nombre}}</option> 
                        @else
                        <option value="{{$direccion->id}}">{{$direccion->calle}}, {{$direccion->numero}} - {{$direccion->cp}}, {{$direccion->provincia->nombre}}</option> 
                        @endif
                    @endforeach
                </select>

                @if (Auth::user()->direcciones->count() < 3)
                <a href="{{route('address.create')}}" class="d-block mt-3 add-address-link"><i class="bi bi-plus"></i>Añadir dirección</a>
                @endif
            </div>

            {{-- <div class="mt-2">
                <label for="provincia" class="form-label">Provincia *</label>
                <select name="provincia" id="provincia" class="col-12 form-select" required>
                    @foreach ($provincias as $provincia)
                        @if (Auth::user()->direcciones()->count()>0 && $provincia->nombre == Auth::user()->getDireccionPrincipal()->provincia->nombre)
                        <option value="{{$provincia->nombre}}" selected>{{$provincia->nombre}}</option>
                        @else
                        <option value="{{$provincia->nombre}}">{{$provincia->nombre}}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="mt-2 d-flex flex-column col-md-6">
                <label for="cp" class="form-label">Código postal *</label>
                @if (Auth::user()->direcciones()->count()>0)
                <input type="tel" name="cp" id="cp" class="form-control" value="{{Auth::user()->getDireccionPrincipal()->cp}}" maxlength="5" required>
                @else
                <input type="tel" name="cp" id="cp" class="form-control" maxlength="5" required>
                @endif
            </div>

            <div class="mt-2 col-md-6">
                <label for="direccion" class="form-label">Dirección de la calle *</label>
                @if (Auth::user()->direcciones()->count()>0)
                <input type="text" name="direccion" id="direccion" value="{{Auth::user()->getDireccionPrincipal()->calle}}, {{Auth::user()->getDireccionPrincipal()->numero}}" class="col-12 form-control" required>
                @else
                <input type="text" name="direccion" id="direccion" placeholder="Calle Ejemplo, 27" class="col-12 form-control" required>
                @endif
            </div> --}}
        </div>

        <div class="pedido__container col-md-5 border pb-4">
            <p class="fw-bold">Tu pedido</p>
            <table class="table">
                <thead class="border-3 border-botom">
                    <th>PRODUCTO</th>
                    <th>SUBTOTAL</th>
                </thead>
                <tbody>
                    @foreach (Auth::user()->carrito->items as $item)
                        <tr>
                            <td>{{$item->libro->titulo}} <strong>x {{$item->cantidad}}</strong></td>
                            <td><strong>{{$item->subtotal}} €</strong></td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="border-3 border-bottom">
                    <td><strong>Total</strong></td>
                    <td><strong>{{$total}} €</strong></td>
                </tfoot>
            </table>

            <p class="fw-bold">Método de pago</p>
            <ul class="metodos-pago d-flex flex-column">
                <div>
                    <input type="radio" name="metodo" id="tarjeta" value="Tarjeta de crédito" required>
                    <label for="tarjeta">Tarjeta de crédito</label>
                </div>

                <div>
                    <input type="radio" name="metodo" id="paypal" value="PayPal" required>
                    <label for="tarjeta">PayPal</label>
                </div>
                
                <div>
                    <input type="radio" name="metodo" id="bizum" value="Bizum" required>
                    <label for="tarjeta">Bizum</label>
                </div>
            </ul>
            <button id="confirm-order" type="submit">Realizar pedido</button>
        </div>

        {{-- MODAL --}}
        <div id="modal-metodo-pago" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Introduzca los datos de su tarjeta de crédito</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row gap-4">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btn-finalizar-compra" class="btn btn-primary">Finalizar compra</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</form>

</div>
@endsection