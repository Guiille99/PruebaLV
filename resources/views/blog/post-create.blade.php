@extends('layouts.plantilla-admin')
@section('title', 'Admin | Nuevo Post')
@section('content')
    <div class="register__section new-post__container">
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
                       <label for="cuerpo" class="form-label ms-1">Cuerpo del post</label>
                       @error('cuerpo')
                            <small class="text-danger">* {{$message}}</small>
                        @enderror
                    </div>

                    <div class="col col-md-2 mt-4">
                        <button type="submit" class="btn-add w-100">Crear post</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
{{-- @section('script')
<script>
    $("#form-new-post #titulo").keyup(function(){
        let titulo = $(this).val();
        let slug = getSlug(titulo);
        $("#slug").val(slug);
    })
    function getSlug(titulo) {
        titulo = titulo.toLowerCase()
                .trim()
                .split(" ").join("-") //Reemplaza los espacios en blanco entre las palabras por guiones
                .replace(/[áéíóú]/gi, match => { //Elimina las tildes de las vocales
                    switch (match) {
                        case 'á': return 'a';
                        case 'é': return 'e';
                        case 'í': return 'i';
                        case 'ó': return 'o';
                        case 'ú': return 'u';
                    }
                })
                //Elimina todos los caracteres que no son letras, números, espacios en blanco o guiones y las ñ las reemplaza por n
                .replace(/[^\w\s-]/g, function(char){ 
                    char = char.toLowerCase();
                    return (char=='ñ') ? 'n' : '';
                })
        return titulo;
    }
</script>
@endsection --}}