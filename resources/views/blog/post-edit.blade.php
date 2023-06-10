@extends('layouts.plantilla-admin')
@section('title', 'Admin | Editar Post')
<script src="{{asset('build/assets/ckeditor.js')}}"></script>
@section('content')
    <div class="register__section edit-post__container form__modify__container">
        <div class="title">
            <p>Detalles del post <i>"{{$post->nombre}}"</i></p>
        </div>
        <form action="{{route('update.post', $post)}}" id="form-new-post" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="container-fluid">
                <div class="row">
                    <div class="portada-image-section mt-3">
                        <figure>
                            <img src="{{asset($post->portada)}}" alt="Portada de {{$post->nombre}}" class="img-fluid">
                        </figure>
                        <div class="form-floating col-12 col-md-4">
                            <input type="file" name="portada" id="portada" class="form-control" placeholder="Portada">
                            <label for="portada" class="form-label ms-1">Portada</label>
                            @error('portada')
                                <small class="text-danger">* {{$message}}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-floating mt-3 col-md-6">
                        <input type="text" name="titulo" id="titulo" class="form-control" value="{{$post->nombre}}" placeholder="Título">
                        <label for="titulo" class="form-label ms-1">Título</label>
                        @error('titulo')
                            <small class="text-danger">* {{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-floating mt-3 col-md-6">
                        <input type="text" name="slug" id="slug" class="form-control" value="{{$post->slug}}" placeholder="Slug" readonly>
                        <label for="slug" class="form-label ms-1">Slug</label>
                        @error('slug')
                            <small class="text-danger">* {{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-floating mt-3 col-md-6">
                        <select id="categorias" class="form-select" name="categoria" aria-label="Default select example">
                            @foreach ($categorias as $categoria)
                                @if ($post->categoria->nombre == $categoria->nombre)
                                <option value="{{$categoria->nombre}}" selected>{{$categoria->nombre}}</option>
                                @else
                                <option value="{{$categoria->nombre}}">{{$categoria->nombre}}</option>
                                @endif
                            @endforeach
                          </select>
                          <label for="categorias" class="form-label ms-1">Categoría</label>
                          @error('categoria')
                            <small class="text-danger">* {{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-floating mt-3">
                       <textarea  id="cuerpo" name="cuerpo" class="form-control" placeholder="Cuerpo del post">{{$post->cuerpo}}</textarea>
                       <label for="cuerpo" class="form-label ms-1"></label>
                       @error('cuerpo')
                            <small class="text-danger">* {{$message}}</small>
                        @enderror
                    </div>

                    <div class="buttons__container mt-4">
                        <button type="submit" class="btn-modify">Modificar post</button>
                        <a href="{{route('admin.posts')}}" class="btn-back">Volver</a>
                    </div>
                </div>
            </div>
        </form>

        <div class="comentarios__container">
            <div class="title">
                <p>Comentarios</p>
            </div>
            <div class="comentarios">
                @if (count($comentarios)==0)
                    <p class="text-center">No hay comentarios en este post</p>
                @else
                    @foreach ($comentarios as $comentario)
                        <div class="comentario">
                            <figure class="img-profile">
                                <img src="{{asset($comentario->user->avatar)}}" alt="Imagen de perfil de {{$comentario->user->username}}" class="img-fluid">
                            </figure>
                            <div class="user__info">
                                <div class="user__info-username-date">
                                    <p class="username">{{$comentario->user->username}}</p>
                                    @if ($comentario->created_at->diffInDays() > 0)
                                        <p class="date">{{$comentario->created_at->format("d/m/Y")}}</p>
                                    @else
                                        <p class="date">{{ucfirst($comentario->created_at->diffForHumans())}}</p>
                                    @endif

                                    <button class="btn-delete" data-id="{{$comentario->id}}" data-bs-toggle="modal" data-bs-target="#modal-delete" aria-label="Eliminar comentario" title="Eliminar comentario"><i class="bi bi-trash3-fill"></i></button>
                                </div>
                                <p>{{$comentario->cuerpo}}</p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="modal fade" id="modal-delete" tabindex="-1" aria-labelledby="eliminacionComentarioModal" aria-hidden="true">
            <div class="modal-dialog">
                <form action="" method="post">
                    @csrf
                    @method('delete')
                
                    <div class="modal-content">
                        <div class="modal-header d-flex gap-2">
                            <i class="bi bi-exclamation-circle"></i>
                            <h1 class="modal-title fs-5" id="eliminacionComentarioModal">Eliminación de comentario</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ¿Está seguro de que quiere eliminar el libro <strong></strong>?
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        
                        <button type="submit" class="btn btn-danger text-white">Confirmar</button>
                        </div>
                    </div>  
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).on('click', 'button.btn-delete', openDeleteModal)

        function openDeleteModal() {
            let id = $(this).attr("data-id");
            let titulo = $(this).attr("data-titulo");
            let token = $("input[name='_token']").val();
            let url = "{{route('comment.destroy', 'num')}}";
            url=url.replace('num', id);
            $(".modal-dialog form").attr("action", url); //Actualizo la url para eliminar el comentario
            $(".modal-body").html("¿Está seguro de que quiere eliminar este comentario?")       
        }
        ClassicEditor
            .create( document.querySelector( '#cuerpo' ) )
            .catch( error => {
                console.error( error );
        } );
    </script>
@endsection