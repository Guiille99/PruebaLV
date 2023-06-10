@extends('layouts.plantilla-admin')
@section('title', 'Admin | Nuevo Post')
<script src="{{asset('build/assets/ckeditor.js')}}"></script>
@section('content')
    <div class="form__modify__container register__section new-post__container">
        <div class="title">
            <p>Nuevo post</p>
        </div>
        <form action="{{route('store.post')}}" id="form-new-post" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container-fluid">
                <div class="row">
                    <div class="form-floating mt-3 col-md-6">
                        <input type="text" name="titulo" id="titulo" class="form-control" value="{{old('titulo')}}" placeholder="Título">
                        <label for="titulo" class="form-label ms-1">Título</label>
                        @error('titulo')
                            <small class="text-danger">* {{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-floating mt-3 col-md-6">
                        <input type="text" name="slug" id="slug" class="form-control" value="{{old('slug')}}" placeholder="Slug" readonly>
                        <label for="slug" class="form-label ms-1">Slug</label>
                        @error('slug')
                            <small class="text-danger">* {{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-floating mt-3 col-md-6">
                        <input type="file" name="portada" id="portada" class="form-control" placeholder="Portada">
                        <label for="portada" class="form-label ms-1">Portada</label>
                        @error('portada')
                            <small class="text-danger">* {{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-floating mt-3 col-md-6">
                        <select id="categorias" class="form-select" name="categoria" aria-label="Default select example">
                            @foreach ($categorias as $categoria)
                                <option value="{{$categoria->nombre}}">{{$categoria->nombre}}</option>
                            @endforeach
                          </select>
                          <label for="categorias" class="form-label ms-1">Categoría</label>
                          @error('categoria')
                            <small class="text-danger">* {{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-floating mt-3">
                       <textarea  id="cuerpo" name="cuerpo" class="form-control" placeholder="Cuerpo del post">{{old('cuerpo')}}</textarea>
                       <label for="cuerpo" class="form-label ms-1"></label>
                       @error('cuerpo')
                            <small class="text-danger">* {{$message}}</small>
                        @enderror
                    </div>

                    <div class="buttons__container mt-4">
                        <button type="submit" class="btn-add">Crear post</button>
                        <a href="{{route('admin.posts')}}" class="btn-back">Volver</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
<script>
    ClassicEditor
        .create( document.querySelector( '#cuerpo' ) )
        .catch( error => {
            console.error( error );
    } );
</script>
@endsection