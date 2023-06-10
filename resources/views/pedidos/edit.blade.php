@extends('layouts.plantilla-admin')
@section('title', 'Admin | Edición de pedido')
@section('content')
    <div class="order__container register__section mt-4">
        <div class="title">
            <p>Detalles del pedido # {{$pedido->id}}</p>
            <span class="message_info">* Únicamente se puede modificar el estado del pedido</span>
        </div>
        <div class="content order-details form__modify__container">
            <form action="{{route('update.order', $pedido)}}" method="post">
                @csrf
                @method('put')
                <div class="container-fluid">
                    <div class="row justify-content-end">
                        <div class="form-floating mt-3 col-md-3">
                            <input type="text" name="nPedido" id="nPedido" class="form-control" value="{{$pedido->id}}" placeholder="Nº de pedido" readonly>
                            <label for="nPedido" class="form-label ms-1">Nº de pedido</label>
                        </div>
                        @if ($pedido->user == null)
                            <div class="form-floating mt-3 col-md-3">
                                <input type="text" name="username" id="username" class="form-control" value="Usuario eliminado" placeholder="Nombre de usuario" readonly>
                                <label for="username" class="form-label ms-1">Nombre de usuario</label>
                            </div>
                            <div class="form-floating mt-3 col-md-3">
                                <input type="text" name="nombre" id="nombre" class="form-control" value="" placeholder="Nombre" readonly>
                                <label for="nombre" class="form-label ms-1">Nombre</label>
                            </div>
                            <div class="form-floating mt-3 col-md-3">
                                <input type="text" name="apellidos" id="apellidos" class="form-control" value="" placeholder="Apellidos" readonly>
                                <label for="apellidos" class="form-label ms-1">Apellidos</label>
                            </div>        
                        @else
                            <div class="form-floating mt-3 col-md-3">
                                <input type="text" name="username" id="username" class="form-control" value="{{$pedido->user->username}}" placeholder="Nombre de usuario" readonly>
                                <label for="username" class="form-label ms-1">Nombre de usuario</label>
                            </div>
                            <div class="form-floating mt-3 col-md-3">
                                <input type="text" name="nombre" id="nombre" class="form-control" value="{{$pedido->user->nombre}}" placeholder="Nombre" readonly>
                                <label for="nombre" class="form-label ms-1">Nombre</label>
                            </div>
                            <div class="form-floating mt-3 col-md-3">
                                <input type="text" name="apellidos" id="apellidos" class="form-control" value="{{$pedido->user->apellidos}}" placeholder="Apellidos" readonly>
                                <label for="apellidos" class="form-label ms-1">Apellidos</label>
                            </div>
                        @endif
                        <div class="form-floating mt-3 col-md-3">
                            <select id="estado" class="form-select" name="estado" aria-label="Default select example">
                                @foreach ($estados as $estado)
                                    @if ($estado->nombre == $pedido->estado)
                                    <option value="{{$estado->nombre}}" selected>{{$estado->nombre}}</option>
                                    @else
                                    <option value="{{$estado->nombre}}">{{$estado->nombre}}</option>
                                    @endif
                                @endforeach
                              </select>
                              <label for="estado" class="form-label ms-1">Estado</label>
                        </div>
                        <div class="form-floating mt-3 col-md-3">
                            <input type="text" name="fecha" id="fecha" class="form-control" value="{{$pedido->created_at->format('d/m/Y H:i:s')}}" placeholder="Fecha de pedido" readonly>
                            <label for="fecha" class="form-label ms-1">Fecha de pedido</label>
                        </div>
                        <div class="form-floating mt-3 col-md-3">
                            <input type="text" name="tpago" id="tpago" class="form-control" value="{{$pedido->tipo_pago}}" placeholder="Tipo de pago" readonly>
                            <label for="tpago" class="form-label ms-1">
                                Tipo de pago 
                                @if ($pedido->tipo_pago=="Tarjeta de crédito")
                                <i class="bi bi-credit-card"></i>
                                @elseif($pedido->tipo_pago=="PayPal")
                                <i class="bi bi-paypal"></i>
                                @endif
                            </label>
                        </div>
                        <div class="form-floating mt-3 col-md-3">
                            <input type="text" name="direccion" id="direccion" class="form-control" value="{{$pedido->direccion->calle}}, {{$pedido->direccion->numero}} ({{$pedido->direccion->provincia->nombre}} - {{$pedido->direccion->cp}})" placeholder="Dirección" readonly>
                            <label for="direccion" class="form-label ms-1">Dirección</label>
                        </div>

                        <div class="buttons__container mt-4">
                            <input type="submit" class="btn-modify" value="Actualizar">
                            <a href="{{route('showAll.orders')}}" class="btn-back">Volver</a>
                        </div>
                    </div>
                </div>
            </form>

            <div class="books__pedido__container my-2">
                <div class="title">
                    <p>Productos del pedido</p>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <th>Título</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </thead>
                        <tbody>
                            @foreach ($libros as $libro)
                                <tr>
                                    <td>{{$libro->titulo}}</td>
                                    <td>{{$libro->precio}} €</td>
                                    <td>{{$libro->pivot->cantidad}}</td>
                                    <td>{{$libro->pivot->subtotal}} €</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="100%"><strong>Total: </strong> {{$pedido->total}} €</td>
                            </tr>
                        </tfoot>
                    </table>

                    {{$libros->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection