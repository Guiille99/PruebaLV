@extends('layouts.plantilla')
@section("title", "Books | Blog")
{{-- @section('body-class', 'd-flex flex-column justify-content-between vh-100') --}}

@section('content')
    {{-- IMÁGENES PRINCIPALES --}}
    <div class="imagenes__principales py-4 col-md-10 col-lg-9">
        <div class="children blog__card">
            <figure>
            <img src="{{asset('uploads/children.jpg')}}" alt="Libros para niños" class="img-fluid">
        </figure>
            <p>Recomendaciones para niños</p>
        </div>

        <div class="dia__mujer blog__card">
            <figure>
                <img src="{{asset('uploads/dia-mujer.jpg')}}" alt="Día de la mujer" class="img-fluid">
            </figure>
            <div class="mensaje__oferta">
                <p> <span class="porcentaje">5%</span> de dto.</p>
            </div>
            <p>Día de la mujer</p>
        </div>

        <div class="dia__sanvalentin blog__card">
            <figure>
                <img src="{{asset('uploads/heart.jpg')}}" alt="Día de San Valentín" class="img-fluid"> 
            </figure>
            <p>Día de San Valentín</p>
        </div>
    </div>

    {{-- ÚLTIMAS RESEÑAS --}}
    <main class="resenas__container py-3 pb-5">
        <div class="resenas">
            <h1>ÚLTIMAS RESEÑAS</h1>
    
            <div class="resenas__grid col-10 col-lg-9">
                <div class="resena">
                    <figure>
                        <img src="{{asset('uploads/resena1.jpg')}}" alt="Consejos para escribir en tercera persona" class="img-fluid">
                    </figure>
                    <div class="resena__info">
                        <h5>Consejos para escribir una novela en tercera persona</h5>
    
                        <div class="resena__info__publicacion">
                            <p class="resena__autor">Antonio Ramírez</p>
                            <p class="resena__fecha">02/03/2022</p>
                        </div>
                    </div>
                </div>
    
                <div class="resena">
                    <figure>
                        <img src="{{asset('uploads/resena2.jpg')}}" alt="Consejos para escribir en tercera persona" class="img-fluid">
                    </figure>
                    <div class="resena__info">
                        <h5>Crítica a 'La niebla de los bosques'</h5>
    
                        <div class="resena__info__publicacion">
                            <p class="resena__autor">José García</p>
                            <p class="resena__fecha">20/05/2022</p>
                        </div>
                    </div>
                </div>
    
                <div class="resena">
                    <figure>
                        <img src="{{asset('uploads/resena3.jpg')}}" alt="Consejos para escribir en tercera persona" class="img-fluid">
                    </figure>
                    <div class="resena__info">
                        <h5>Podcast con la escritora Sofía González</h5>
    
                        <div class="resena__info__publicacion">
                            <p class="resena__autor">Antonio Ramírez</p>
                            <p class="resena__fecha">23/05/2022</p>
                        </div>
                    </div>
                </div>
    
                <div class="resena">
                    <figure>
                        <img src="{{asset('uploads/resena4.jpg')}}" alt="Consejos para escribir en tercera persona" class="img-fluid">
                    </figure>
                    <div class="resena__info">
                        <h5>Antonio recomienda, 'Recuerda su nombre', de Ricardo Samosa</h5>
    
                        <div class="resena__info__publicacion">
                            <p class="resena__autor">Antonio Ramírez</p>
                            <p class="resena__fecha">01/06/2022</p>
                        </div>
                    </div>
                </div>
    
                <div class="resena">
                    <figure>
                        <img src="{{asset('uploads/resena5.jpg')}}" alt="Consejos para escribir en tercera persona" class="img-fluid">
                    </figure>
                    <div class="resena__info">
                        <h5>Paula recomienda 'Paz mental', de Marta López</h5>
    
                        <div class="resena__info__publicacion">
                            <p class="resena__autor">Paula Sánchez</p>
                            <p class="resena__fecha">20/06/2022</p>
                        </div>
                    </div>
                </div>
    
                <div class="resena">
                    <figure>
                        <img src="{{asset('uploads/resena6.jpg')}}" alt="Consejos para escribir en tercera persona" class="img-fluid">
                    </figure>
                    <div class="resena__info">
                        <h5>Consejos para escribir una novela en tercera persona</h5>
    
                        <div class="resena__info__publicacion">
                            <p class="resena__autor">Antonio Ramírez</p>
                            <p class="resena__fecha">02/03/2022</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- VENTAJAS --}}
            <div class="ventajas__container col-10 col-md-9">
                <div class="ventaja">
                    <i class="bi bi-bag-check"></i>
                    <p>Compra segura</p>
                </div>

                <div class="ventaja">
                    <i class="bi bi-truck"></i>
                    <p>Envío gratis a partir de 15€</p>
                </div>

                <div class="ventaja">
                    <i class="bi bi-shop"></i>
                    <p>Recogida en tienda gratis</p>
                </div>

                <div class="ventaja">
                    <i class="bi bi-arrow-clockwise"></i>
                    <p>Devolución gratis hasta 30 días</p>
                </div>
            </div>
    </main>
@endsection