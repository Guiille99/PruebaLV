@extends('layouts.plantilla-editPerfil')
@section('content-profile')
@section('breadcrumb-profile')
<li class="breadcrumb-item"><a href="{{route('index')}}">Inicio</a></li>
<li class="breadcrumb-item" aria-current="page"><a href="{{route('user.editPerfil', $user)}}">Mi cuenta</a></li> 
<li class="breadcrumb-item active" aria-current="page">Mis datos</li> 
@endsection
@section('miCuenta-isActive', 'active')
    <div class="column account__details profile-section my-data__container">
        <form enctype="multipart/form-data" action="{{route('user.updatePerfil', $user)}}" method="post">
            @csrf
            @method('put')
            <div class="title">
                <p>IMAGEN DE PERFIL</p>
            </div>
            <div class="data py-3 profile-image-section">
                <figure class="m-0">
                    <img src="{{asset(Auth::user()->avatar)}}" alt="Imagen de perfil" class="img-fluid">
                </figure>

                <div class="form-floating col-md-6">
                    <input type="file" name="avatar" id="avatar" class="form-control">
                    <label for="avatar" class="form-label ms-1">Imagen de perfil</label>
                    @error('avatar')
                        <small class="text-danger">* {{$message}}</small> <br>
                    @enderror
                </div>

                {{-- Si la imagen de perfil no es por defecto dará la opción de eliminar la imagen --}}
                @if (Auth::user()->avatar != config('app.constantes.DEFAULT_AVATAR_URL'))
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDeleteImageProfile">
                    <i class="bi bi-trash3"></i>
                    <span>Eliminar</span>
                </button>
                @endif
            </div>
            <div class="title mt-2">
                <p>MIS DATOS</p>
                <p class="require-data-message">* Dato obligatorio</p>
            </div>

            <div class="data">
                <div class="container-fluid">
                    <div class="row">
                        <div class="form-floating mt-3 col-md-6">
                            <input type="text" name="nombre" id="nombre" class="form-control" value="{{$user->nombre}}" placeholder="Nombre" required>
                            <label for="nombre" class="form-label ms-1">* Nombre</label>
                            <div class="invalid-feedback">
                                <small>Nombre obligatorio</small> 
                            </div>
                            @error('nombre')
                                <small class="text-danger">* {{$message}}</small> <br>
                            @enderror
                        </div>
                
                        <div class="form-floating mt-3 col-md-6">
                            <input type="text" name="apellidos" id="apellidos" class="form-control" value="{{$user->apellidos}}" placeholder="Apellidos" required>
                            <label for="apellidos" class="form-label ms-1">* Apellidos</label>
                            <div class="invalid-feedback">
                                <small>Apellidos obligatorio</small> 
                            </div>
                            @error('apellidos')
                                <small class="text-danger">* {{$message}}</small> <br>
                            @enderror
                        </div>
                
                        <div class="form-floating mt-3 col-md-6">
                            <input type="text" name="username" id="username" class="form-control" value="{{$user->username}}" placeholder="Usuario" required>
                            <label for="username" class="form-label ms-1">* Usuario</label>
                            <div class="invalid-feedback">
                                <small>Usuario obligatorio</small> 
                            </div>
                            @error('username')
                                <small class="text-danger">* {{$message}}</small> <br>
                            @enderror
                        </div>
                        <div class="form-floating mt-3 col-md-6">
                            <input type="email" name="email" id="email" class="form-control" value="{{$user->email}}" placeholder="Email" required>
                            <label for="email" class="form-label ms-1">* Email</label>
                            <div class="invalid-feedback">
                                <small>Email inválido</small> 
                            </div>
                            @error('email')
                                <small class="text-danger">* {{$message}}</small> <br>
                            @enderror
                        </div>                
                
                        <div class="mt-4">
                            <input type="submit" value="Actualizar" class="boton">
                        </div>
            
                    </div>
                </div>
        </form>
    </div>
</div>

    <!-- Modal -->
    <form action="{{route('user.deleteImageProfile', $user)}}" method="post">
        @csrf
        @method('delete')
        <div class="modal fade" id="modalDeleteImageProfile" tabindex="-1" aria-labelledby="modalDeleteImageProfileLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex gap-2">
                <i class="bi bi-exclamation-circle"></i>
                <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminación de imagen de perfil</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro de que desea eliminar su imagen de perfil? Esta acción no se podrá deshacer</p>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-danger">Sí, eliminar imagen</button>
                </div>
            </div>
            </div>
        </div>
    </form>
@endsection