@extends('layouts.plantilla')
@section("title", "Books | Contacto")
@section('content')

<div class="container-fluid">
    <main class="contacto__container py-5 row justify-content-center gap-5">
        <div class="contacto col-md-5 col-lg-4">
            <h1 class="contacto__titulo">Contacte con nosotros</h1>
    
            <form action="{{route('contacto.sendMessage')}}" class="mt-3 needs-validation" method="POST" novalidate>
                @csrf
                <div class="">
                    <label for="nombreContacto">Nombre *</label>
                    <input type="text" class="form-control" id="nombreContacto" name="nombre" required>
                    <div class="invalid-feedback">
                        <small class="text-danger">Nombre obligatorio</small> 
                    </div>
                </div>
    
                <div class="mt-3">
                    <label for="emailContacto">Email *</label>
                    <input type="email" class="form-control" id="emailContacto" name="email" required>
                    <div class="invalid-feedback">
                        <small class="text-danger">Email inválido</small> 
                    </div>
                    <div class="valid-feedback">
                        <small class="text-success">Email válido</small> 
                    </div>
                </div>

                <div class="mt-3">
                    <label for="emailContacto">Mensaje *</label>
                    <textarea name="mensaje" id="mensajeContacto" class="form-control" cols="30" rows="10" required></textarea>
                    <div class="invalid-feedback">
                        <small class="text-danger">Mensaje obligatorio</small> 
                    </div>
                </div>
                
                <div class="mt-3">
                    <button type="submit" class="btn-add">Enviar</button>
                </div>
            </form>
        </div>

        <div class="col-md-4">
            <h1 class="contacto__titulo">Datos de contacto</h1>

            <div class="datos mt-3">
                <div class="datos__container datos__direccion">
                    <i class="bi bi-geo-alt-fill"></i>
                    <div class="datos__text">
                        <p class="datos__titulo">Dirección</p>
                        <p class="datos__descripcion">C/Buenos Aires, 22 - Sevilla (España)</p>
                    </div>
                </div>
                <div class="datos__container datos__tlfn">
                    <i class="bi bi-telephone-fill"></i>
                    <div class="datos__text">
                        <p class="datos__titulo">Teléfono</p>
                        <p class="datos__descripcion">623456789</p>
                    </div>
                </div>
                <div class="datos__container datos__email">
                    <i class="bi bi-envelope-fill"></i>
                    <div class="datos__text">
                        <p class="datos__titulo">Email</p>
                        <p class="datos__descripcion">info@book.com</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

@endsection