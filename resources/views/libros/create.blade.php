@extends('layouts.plantilla-admin')
@section('title', 'Creación de libro')
<script src="{{asset('build/assets/ckeditor.js')}}"></script>
@section('content')
<div class="form__modify__container register__section pt-4">
    <div class="title">
        <p>Creación de un nuevo libro</p>
    </div>
    <form action="{{route('libro.store')}}" method="post" class="needs-validation" novalidate enctype="multipart/form-data" >
        @csrf
        <div class="container-fluid">
            <div class="row">
                <div class="form-floating mt-3 col-md-6">
                    <input type="text" name="titulo" id="titulo" class="form-control" value="{{old('titulo')}}" placeholder="titulo" required>
                    <label for="titulo" class="form-label ms-1">Título</label>
                    <div class="invalid-feedback">
                        <small>Título obligatorio</small> 
                    </div>
                    @error('titulo')
                        <small class="text-danger">* {{$message}}</small> <br>
                    @enderror
                </div>
        
                <div class="form-floating mt-3 col-md-6">
                    <input type="text" name="autor" id="autor" class="form-control" value="{{old('autor')}}" placeholder="Autor" required>
                    <label for="autor" class="form-label ms-1">Autor</label>
                    <div class="invalid-feedback">
                        <small>Autor obligatorio</small> 
                    </div>
                    @error('autor')
                        <small class="text-danger">* {{$message}}</small> <br>
                    @enderror
                </div>
        
                <div class="form-floating mt-3 col-md-6">
                    <input type="text" name="editorial" id="editorial" class="form-control" value="{{old('editorial')}}" placeholder="Editorial" required>
                    <label for="editorial" class="form-label ms-1">Editorial</label>
                    <div class="invalid-feedback">
                        <small>Editorial obligatoria</small> 
                    </div>
                    @error('editorial')
                        <small class="text-danger">* {{$message}}</small> <br>
                    @enderror
                </div>


                <div class="form-floating mt-3 col-md-6">
                    <input type="file" name="portada" id="portada" class="form-control"  placeholder="portada">
                    <label for="portada" class="form-label ms-1">Imagen Portada</label>
                    <div class="invalid-feedback">
                        <small>Portada obligatoria</small> 
                    </div>
                    @error('portada')
                        <small class="text-danger">* {{$message}}</small> <br>
                    @enderror
                </div>

                
                <div class="form-floating mt-3">
                    <input type="text" name="isbn" id="isbn" class="form-control" value="{{old('isbn')}}"  placeholder="ISBN" required>
                    <label for="isbn" class="form-label ms-1">ISBN</label>
                    <div class="invalid-feedback">
                        <small>ISBN obligatorio</small> 
                    </div>
                    @error('isbn')
                        <small class="text-danger">* {{$message}}</small> <br>
                    @enderror
                </div>

                <div class="form-floating mt-3 col-md-4">
                    <input type="date" name="fecha_publicacion" id="fecha_publicacion" class="form-control" value="{{old('fecha_publicacion')}}"  placeholder="fecha publicacion" required>
                    <label for="fecha_publicacion" class="form-label ms-1">Fecha Publicación</label>
                    <div class="invalid-feedback">
                        <small>Fecha obligatoria</small> 
                    </div>
                    @error('fecha_pub')
                        <small class="text-danger">* {{$message}}</small> <br>
                    @enderror
                </div>

                <div class="form-floating mt-3 col-md-4">
                    <input type="number" name="precio" id="precio" class="form-control" step="0.01" value="{{old('precio')}}"  placeholder="Precio" required>
                    <label for="precio" class="form-label ms-1">Precio</label>
                    <div class="invalid-feedback">
                        <small>Precio obligatorio</small> 
                    </div>
                    @error('precio')
                        <small class="text-danger">* {{$message}}</small> <br>
                    @enderror
                </div>

                <div class="form-floating mt-3 col-md-4">
                    <input type="text" name="genero" id="genero" class="form-control" value="{{old('genero')}}"  placeholder="Genero" required>
                    <label for="genero" class="form-label ms-1">Género</label>
                    <div class="invalid-feedback">
                        <small>Género obligatorio</small> 
                    </div>
                    @error('genero')
                        <small class="text-danger">* {{$message}}</small> <br>
                    @enderror
                </div>

                <div class="mt-3">
                    <label for="descripcion" class="form-label ms-1">Descripción</label>
                    <textarea name="descripcion" id="descripcion" class="form-control" cols="30" rows="10">{{old('descripcion')}}</textarea>
                    <div class="invalid-feedback">
                        <small>Descripción obligatoria</small> 
                    </div>
                    @error('descripcion')
                        <small class="text-danger">* {{$message}}</small> <br>
                    @enderror
                </div>

                <div class="form-floating mt-3 col-md-4">
                    <input type="number" name="valoracion" id="valoracion" class="form-control" value="{{old('valoracion')}}"  placeholder="Valoracion" step="any" required>
                    <label for="valoracion" class="form-label ms-1">Valoración</label>
                    <div class="invalid-feedback">
                        <small>Valoración obligatoria</small> 
                    </div>
                    @error('valoracion')
                        <small class="text-danger">* {{$message}}</small> <br>
                    @enderror
                </div>

                
                <div class="form-floating mt-3 col-md-4">
                    <input type="number" name="paginas" id="paginas" class="form-control" value="{{old('paginas')}}"  placeholder="Paginas" required>
                    <label for="paginas" class="form-label ms-1">Paginas</label>
                    <div class="invalid-feedback">
                        <small>Paginas obligatoria</small> 
                    </div>
                    @error('paginas')
                        <small class="text-danger">* {{$message}}</small> <br>
                    @enderror
                </div>
                
                <div class="form-floating mt-3 col-md-4">
                    <input type="number" name="stock" id="stock" class="form-control" value="{{old('stock')}}"  placeholder="Stock" required>
                    <label for="stock" class="form-label ms-1">Stock</label>
                    <div class="invalid-feedback">
                        <small>Stock obligatorio</small> 
                    </div>
                    @error('stock')
                        <small class="text-danger">* {{$message}}</small> <br>
                    @enderror
                </div>

                <div class="buttons__container mt-4">
                    <input type="submit" value="Crear Libro" class="btn-add">
                    <a href="{{route('libros.index')}}" class="btn-back">Volver</a>
                </div>
    
            </div>
        </div>

    </form>
</div>
@endsection
@section('script')
<script>
    ClassicEditor
        .create( document.querySelector( '#descripcion' ) )
        .catch( error => {
            console.error( error );
    } );
</script>
@endsection