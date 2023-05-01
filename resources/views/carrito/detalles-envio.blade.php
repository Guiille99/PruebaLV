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
{{-- {{$provincias}} --}}
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
 
            <div class="mt-2">
                <label for="provincia" class="form-label">Provincia *</label>
                <select name="provincia" id="provincia" class="col-12 form-select" required>
                    @foreach ($provincias as $provincia)
                        <option value="{{$provincia->nombre}}">{{$provincia->nombre}}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-2 d-flex flex-column col-md-6">
                <label for="cp" class="form-label">Código postal *</label>
                <input type="tel" name="cp" id="cp" class="form-control" maxlength="5" required>
                {{-- <div class="invalid-feedback">
                    Formato incorrecto. Ej: 12345
                </div> --}}
            </div>

            <div class="mt-2 col-md-6">
                <label for="direccion" class="form-label">Dirección de la calle *</label>
                <input type="text" name="direccion" id="direccion" placeholder="Calle Ejemplo, 27" class="col-12 form-control" required>
            </div>
        </div>

        <div class="pedido__container col-md-5 border pb-4">
            <p class="fw-bold">Tu pedido</p>
            <table class="table">
                <thead class="border-3 border-botom">
                    <th>PRODUCTO</th>
                    <th>SUBTOTAL</th>
                </thead>
                <tbody>
                    @foreach (session()->get('carrito') as $id => $libro)
                        <tr>
                            <td>{{$libro["titulo"]}} <strong>x {{$libro["cantidad"]}}</strong></td>
                            <td><strong>{{$libro["precio"]*$libro["cantidad"]}} €</strong></td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="border-3 border-bottom">
                    <td><strong>Total</strong></td>
                    <td><strong>{{session()->get('carrito-data')["total"]}} €</strong></td>
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