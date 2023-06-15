@extends('layouts.plantilla-admin')
@section('title', 'Books | Admin - Pedidos')
@section('content')
<div id="registros__container" class="mt-5">
    <div class="header__container justify-content-start mb-2">
        <h3 class="title">Últimos pedidos</h3>
    </div>
    <div class="registros">
        <table id="last-orders" class="table text-center table-striped table-hover w-100">
            <thead>
                <th>Nº pedido</th>
                <th>Usuario</th> 
                <th>Total</th> 
                <th>Estado</th> 
                <th>Tipo de pago</th> 
                <th>Fecha de compra</th>
                <th>Acciones</th> 
            </thead>

            <tbody>
                <div class="modal fade" id="modal-delete" tabindex="-1" aria-labelledby="modalEliminacionPedido" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="modal-delete-form" action="" method="post">
                            @csrf
                            @method('delete')
                        
                            <div class="modal-content">
                                <div class="modal-header d-flex gap-2">
                                    <i class="bi bi-exclamation-circle"></i>
                                    <h1 class="modal-title fs-5" id="modalEliminacionPedido"> Eliminación de pedido</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Está seguro de que quiere eliminar el pedido? Esta acción no podrá deshacerse.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-danger text-white">Confirmar</button>
                                </div>
                            </div>  
                        </form>
                    </div>
                </div>
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function () {
        $.fn.dataTable.ext.errMode = 'throw';
        $('#last-orders').DataTable({
            processing:true,
            serverSide: true,
            responsive: true,
            ajax: "{{route('show.last-orders')}}",
            order: [[0, "desc"]],
            columns:[
                {data: 'id'},
                {data: 'user_id'},
                {data: 'total'},
                {data: 'estado'},
                {data: 'tipo_pago'},
                {data: 'created_at'},
                {data: 'action'},
            ],
            lengthMenu: [5, 10, 15],
            columnDefs: [
                {orderable: false, target:[6]},
                {targets: [2], render: function(data, type, row){
                        return data + " €";
                }},
                {targets: [5], render: function(data, type, row){
                        return moment.utc(data).local().format('DD/MM/YYYY HH:mm:ss');
                }},
            ],
            language: {
                "processing": "<div class='spinner-border' role='status'><span class='visually-hidden'>Loading...</span></div>",
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "emptyTable": "Ningún dato disponible en esta tabla",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "search": "Buscar:",
                "infoThousands": ",",
                "loadingRecords": "<div class='spinner-border' role='status'><span class='visually-hidden'>Loading...</span></div>",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": ">",
                    "previous": "<"
                },
                "aria": {
                    "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sortDescending": ": Activar para ordenar la columna de manera descendente"
                },
                "decimal": ",",
                "searchBuilder": {
                    "add": "Añadir condición",
                    "button": {
                        "0": "Constructor de búsqueda",
                        "_": "Constructor de búsqueda (%d)"
                    },
                    "clearAll": "Borrar todo",
                    "condition": "Condición",
                    "conditions": {
                        "date": {
                            "after": "Despues",
                            "before": "Antes",
                            "between": "Entre",
                            "empty": "Vacío",
                            "equals": "Igual a",
                            "notBetween": "No entre",
                            "notEmpty": "No Vacio",
                            "not": "Diferente de"
                        },
                        "number": {
                            "between": "Entre",
                            "empty": "Vacio",
                            "equals": "Igual a",
                            "gt": "Mayor a",
                            "gte": "Mayor o igual a",
                            "lt": "Menor que",
                            "lte": "Menor o igual que",
                            "notBetween": "No entre",
                            "notEmpty": "No vacío",
                            "not": "Diferente de"
                        },
                        "string": {
                            "contains": "Contiene",
                            "empty": "Vacío",
                            "endsWith": "Termina en",
                            "equals": "Igual a",
                            "notEmpty": "No Vacio",
                            "startsWith": "Empieza con",
                            "not": "Diferente de",
                            "notContains": "No Contiene",
                            "notStartsWith": "No empieza con",
                            "notEndsWith": "No termina con"
                        },
                        "array": {
                            "not": "Diferente de",
                            "equals": "Igual",
                            "empty": "Vacío",
                            "contains": "Contiene",
                            "notEmpty": "No Vacío",
                            "without": "Sin"
                        }
                    },
                    "data": "Data",
                    "deleteTitle": "Eliminar regla de filtrado",
                    "leftTitle": "Criterios anulados",
                    "logicAnd": "Y",
                    "logicOr": "O",
                    "rightTitle": "Criterios de sangría",
                    "title": {
                        "0": "Constructor de búsqueda",
                        "_": "Constructor de búsqueda (%d)"
                    },
                    "value": "Valor"
                },
                "searchPanes": {
                    "clearMessage": "Borrar todo",
                    "collapse": {
                        "0": "Paneles de búsqueda",
                        "_": "Paneles de búsqueda (%d)"
                    },
                    "count": "{total}",
                    "countFiltered": "{shown} ({total})",
                    "emptyPanes": "Sin paneles de búsqueda",
                    "loadMessage": "Cargando paneles de búsqueda",
                    "title": "Filtros Activos - %d",
                    "showMessage": "Mostrar Todo",
                    "collapseMessage": "Colapsar Todo"
                },
                "select": {
                    "cells": {
                        "1": "1 celda seleccionada",
                        "_": "%d celdas seleccionadas"
                    },
                    "columns": {
                        "1": "1 columna seleccionada",
                        "_": "%d columnas seleccionadas"
                    },
                    "rows": {
                        "1": "1 fila seleccionada",
                        "_": "%d filas seleccionadas"
                    }
                },
                "thousands": ".",
                "datetime": {
                    "previous": "Anterior",
                    "next": "Proximo",
                    "hours": "Horas",
                    "minutes": "Minutos",
                    "seconds": "Segundos",
                    "unknown": "-",
                    "amPm": [
                        "AM",
                        "PM"
                    ],
                },
                "editor": {
                    "close": "Cerrar",
                    "error": {
                        "system": "Ha ocurrido un error en el sistema (<a target=\"\\\" rel=\"\\ nofollow\" href=\"\\\">Más información&lt;\\\/a&gt;).<\/a>"
                    }
                },
                "info": "Mostrando <strong>_START_</strong> a <strong>_END_</strong> de <strong>_TOTAL_</strong> registros",
            } 
        });

    });

    $(document).on('click', 'table button.btn-delete', openDeleteModal)

    function openDeleteModal() {
        let id = $(this).attr("data-id");
        let token = $("input[name='_token']").val();
        let url = "{{route('order.destroy', 'num')}}";
        url=url.replace('num', id);

        $("#modal-delete-form").attr("action", url); //Actualizo la url para eliminar el pedido    
    }
</script>
@endsection