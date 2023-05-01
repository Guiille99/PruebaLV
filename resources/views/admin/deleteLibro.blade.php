{{-- MODAL PARA CONFIRMAR BORRADO DE LIBRO --}}
<!-- Modal -->
<div class="modal fade" id="modal-delete-{{$libro->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{route('libro.destroy', $libro)}}" method="post">
            @csrf
            @method('delete')
        
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminación de registro</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Está seguro de que quiere eliminar el libro <strong>{{$libro->titulo}}</strong>?
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

                <button type="submit" class="btn btn-primary text-white">Confirmar</button>
                </div>
            </div>  
        </form>
    </div>
</div>