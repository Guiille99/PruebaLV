@extends('layouts.plantilla-admin')
@section('title', 'Books | Modificación de usuario')
@section('content')
<div class="form__modify__container profile-section register__section pt-4">
   
    <div class="title">
        <p>Modificación del usuario {{$user->username}}</p>
    </div>
    <form action="{{route('user.update', $user)}}" method="post" class="needs-validation" enctype="multipart/form-data" novalidate>
        @csrf
        @method('put')
        <div class="container-fluid">
            <div class="row">
                {{-- Sección para la imagen de perfil --}}
                <div class="data py-3 profile-image-section">
                    <figure class="m-0">
                        <img src="{{asset($user->avatar)}}" alt="Imagen de perfil" class="img-fluid">
                    </figure>
    
                    <div class="form-floating col-md-6">
                        <input type="file" name="avatar" id="avatar" class="form-control">
                        <label for="avatar" class="form-label ms-1">Imagen de perfil</label>
                        @error('avatar')
                            <small class="text-danger">* {{$message}}</small> <br>
                        @enderror
                    </div>
    
                    {{-- Si la imagen de perfil no es por defecto dará la opción de eliminar la imagen --}}
                    @if ($user->avatar != config('app.constantes.DEFAULT_AVATAR_URL'))
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDeleteImageProfile">
                        <i class="bi bi-trash3"></i>
                        <span>Eliminar</span>
                    </button>
                    @endif
                </div>

                <div class="form-floating mt-3 col-md-6">
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{$user->nombre}}" placeholder="Nombre" required>
                    <label for="nombre" class="form-label ms-1">Nombre</label>
                    <div class="invalid-feedback">
                        <small>Nombre obligatorio</small> 
                    </div>
                    @error('nombre')
                        <small class="text-danger">* {{$message}}</small> <br>
                    @enderror
                </div>
        
                <div class="form-floating mt-3 col-md-6">
                    <input type="text" name="apellidos" id="apellidos" class="form-control" value="{{$user->apellidos}}" placeholder="Apellidos" required>
                    <label for="apellidos" class="form-label ms-1">Apellidos</label>
                    <div class="invalid-feedback">
                        <small>Apellidos obligatorio</small> 
                    </div>
                    @error('apellidos')
                        <small class="text-danger">* {{$message}}</small> <br>
                    @enderror
                </div>
        
                <div class="form-floating mt-3 col-md-6">
                    <input type="text" name="username" id="username" class="form-control" value="{{$user->username}}" placeholder="Usuario" required>
                    <label for="username" class="form-label ms-1">Usuario</label>
                    <div class="invalid-feedback">
                        <small>Usuario obligatorio</small> 
                    </div>
                    @error('username')
                        <small class="text-danger">* {{$message}}</small> <br>
                    @enderror
                </div>


                <div class="form-floating mt-3 col-md-6">
                    <input type="password" name="password" id="password" class="form-control" value="" placeholder="Contraseña">
                    <i id="togglePassword" class="bi bi-eye"></i>
                    <label for="password" class="form-label ms-1">Contraseña</label>
                    <div class="invalid-feedback">
                        <small>Contraseña obligatoria</small> 
                    </div>
                    @error('password')
                        <small class="text-danger">* {{$message}}</small> <br>
                    @enderror
                </div>

                <div class="form-floating col-md-6 mt-3">
                    <input type="email" name="email" id="email" class="form-control" value="{{$user->email}}" placeholder="Email" required>
                    <label for="email" class="form-label ms-1">Email</label>
                    <div class="invalid-feedback">
                        <small>Email inválido</small> 
                    </div>
                    @error('email')
                        <small class="text-danger">* {{$message}}</small> <br>
                    @enderror
                </div>

                <div class="mt-3 col-md-6">
                    <select name="rol" id="rol" class="form-select h-100" aria-label="rol" required>
                        <option value="">-- Selecciona un rol --</option>
                        @if ($user->rol=="Usuario")
                            <option value="Usuario" selected>Usuario</option>
                        @else
                            <option value="Usuario">Usuario</option>
                        @endif

                        @if ($user->rol=="Administrador")
                            <option value="Administrador" selected>Aministrador</option>
                            
                        @else
                            <option value="Administrador">Aministrador</option>
                        @endif
                    </select>
                </div>
        
        
                <div class="buttons__container mt-4">
                    <input type="submit" value="Modificar" class="btn-modify">
                    <a href="{{route('admin.users')}}" class="btn-back">Volver</a>
                </div>
    
            </div>
        </div>

    </form>
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