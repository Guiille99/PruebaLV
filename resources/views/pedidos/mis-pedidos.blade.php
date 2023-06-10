@extends('layouts.plantilla-editPerfil')
@section('content-profile')
@section('breadcrumb-profile')
<li class="breadcrumb-item"><a href="{{route('index')}}">Inicio</a></li>
<li class="breadcrumb-item active" aria-current="page">Mis pedidos</li> 
@endsection
@section('misPedidos-isActive', 'active')
    <div class="column account__details order-section w-100">
        <div class="title">
            <p>MIS PEDIDOS</p>
        </div>
        @if ($pedidos->count()==0)
        <div class="alert alert-warning mt-2" role="alert">
            <i class="bi bi-exclamation-triangle"></i>
            <span>Aún no ha realizado ningún pedido desde esta cuenta</span>
          </div>
        @else
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <th>Número de pedido</th>
                    <th>Fecha de pedido</th>
                    <th>Estado</th>
                    <th>Tipo de pago</th>
                    <th>Total</th>
                </thead>
                <tbody>
                    @foreach ($pedidos as $pedido)
                        <tr>
                            <td>{{$pedido->id}}</td>
                            <td>{{$pedido->created_at->format('d-m-Y H:i:s')}}</td>
                            <td>{{$pedido->estado}}</td>
                            <td>{{$pedido->tipo_pago}}</td>
                            <td>{{$pedido->total}}€</td>
                            @if ($pedido->estado=="Pre-admisión")
                                <td><button class="btn btn-outline-danger btn-cancel-order" data-bs-toggle="modal" data-bs-target="#cancelOrderModal" data-idPedido={{$pedido->id}}>Cancelar</button></td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
            <div class="pagination__container mt-3">
                {{$pedidos->links()}}
            </div>
            <!-- Modal -->
            <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
                <form action="" method="post">
                    @csrf
                    @method('put')
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header d-flex gap-2">
                                <i class="bi bi-exclamation-circle"></i>
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Cancelar pedido</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>¿Está seguro de cancelar este pedido? Esta acción no podrá deshacerse.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-danger">Sí, cancelar pedido</button>
                            </div>
                        </div>
                    </div>
                </form> 
            </div>
        @endif
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $(".btn-cancel-order").click(openCancelOrderModal);

            function openCancelOrderModal(){
                let formModal = $("#cancelOrderModal form");
                let id = $(this).attr('data-idpedido');
                let url = "{{route('order.cancel', 'num')}}";
                url=url.replace('num', id);
                formModal.attr('action', url);
            }
        })
    </script>
@endsection