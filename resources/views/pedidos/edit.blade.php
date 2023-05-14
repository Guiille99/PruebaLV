@extends('layouts.plantilla-admin')
@section('title', 'Admin | Edición de pedido')
@section('content')
    <div class="order__container register__section mt-4">
        <div class="title">
            <p>Detalles del pedido # {{$pedido->id}}</p>
            <span class="message_info">* Únicamente se puede modificar el estado del pedido</span>
        </div>
        <div class="content order-details">
            <form action="{{route('update.order', $pedido)}}" method="post">
                @csrf
                @method('put')
                <div class="container-fluid">
                    <div class="row">
                        <div class="form-floating mt-3 col-md-3">
                            <input type="text" name="nPedido" id="nPedido" class="form-control" value="{{$pedido->id}}" placeholder="Nº de pedido" readonly>
                            <label for="nPedido" class="form-label ms-1">Nº de pedido</label>
                        </div>
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
                            <input type="text" name="fecha" id="fecha" class="form-control" value="{{$pedido->created_at->format('d/m/Y H:m:s')}}" placeholder="Fecha de pedido" readonly>
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
                    </div>
                    <div class="mt-3 float-end">
                        <input type="submit" class="btn-modify" value="Actualizar">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection