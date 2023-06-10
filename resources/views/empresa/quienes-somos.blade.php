@extends('layouts.plantilla')
@section('title', 'Books | Quiénes somos')    
@section('content')
<div class="container">
    <nav class="pt-3" aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{route('index')}}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Quiénes somos</li> 
        </ol>
    </nav>
    <div class="quienes-somos__container info-empresa__container">
        <div class="portada">
            <h1 id="title">QUIÉNES SOMOS</h1>
        </div>
        <div class="info__content">
            <p>En <strong>Books</strong>, creemos en el poder de las palabras y el conocimiento para transformar vidas. Desde nuestra fundación en 1999, nos hemos dedicado apasionadamente a fomentar la cultura y el amor por la lectura en nuestra comunidad.</p>
            <p>Nuestro objetivo es ser más que una simple librería; queremos ser un refugio para los amantes de los libros, un espacio donde la imaginación y la curiosidad encuentren su hogar. Ofrecemos una amplia selección de títulos en diferentes géneros y formatos, desde los clásicos literarios hasta las últimas novedades, además de grandes funcionalidades donde podrás interactuar con otros amantes de la literatura de forma fácil y sencilla. Nuestro equipo está formado por apasionados bibliófilos que estarán encantados de ayudarte a encontrar el libro perfecto.</p>
            <p>Además de nuestra colección de libros, organizamos regularmente eventos literarios, clubes de lectura y talleres creativos. Creemos que la literatura es un puente que conecta a las personas, y nos esforzamos por crear oportunidades para que nuestra comunidad se reúna y comparta su amor por la lectura.</p>
            <p>Nos enorgullece ser parte del tejido cultural de esta ciudad, y nos comprometemos a apoyar a autores locales y artistas emergentes. También colaboramos con instituciones educativas y organizaciones sin fines de lucro para promover la alfabetización y la educación.</p>
            <p>Te invitamos a visitar nuestra librería, sumergirte en la magia de las historias y descubrir nuevos mundos entre sus páginas. Únete a nuestra comunidad de lectores y descubre el placer infinito de perderse en un buen libro. ¡Esperamos verte pronto en <strong>Books</strong>!"</p>
        </div>
    </div>
</div>
@endsection