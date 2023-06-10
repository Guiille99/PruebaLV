@extends('layouts.plantilla')
@section('title', 'Books | Política de cookies')    
@section('content')
<div class="container">
    <nav class="pt-3" aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{route('index')}}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Política de cookies</li> 
        </ol>
    </nav>
    <div class="info-empresa__container">
        <div class="portada">
            <h1 id="title">POLÍTICA DE COOKIES</h1>
        </div>
        <div class="info__content">
            <p><strong>Última actualización: 05/06/2023</strong></p>
            <p>En <strong>Books</strong>, utilizamos cookies y tecnologías similares en nuestro sitio web para mejorar tu experiencia de navegación y proporcionarte un servicio personalizado. Esta Política de Cookies explica qué son las cookies, cómo las utilizamos y tus opciones con respecto a su uso.</p>
            <ol>
                <li>
                    <p class="condicion">¿Qué son las cookies?</p>
                    <p>Las cookies son pequeños archivos de texto que se almacenan en tu dispositivo (como computadora, tablet o smartphone) cuando visitas nuestro sitio web. Estas cookies contienen información que se utiliza para mejorar la funcionalidad y el rendimiento del sitio, recordar tus preferencias y proporcionarte una experiencia más personalizada.</p>
                </li>
                <li class="mb-3">
                    <p class="condicion">Tipos de cookies que utilizamos</p>
                    <p>Utilizamos diferentes tipos de cookies en nuestro sitio web:</p>
                    <ul>
                        <li><strong>Cookies esenciales:</strong> Estas cookies son necesarias para que puedas navegar por el sitio y utilizar sus funciones principales. No recopilan información personal y son esenciales para el funcionamiento del sitio.</li>
                        <li><strong>Cookies de rendimiento:</strong> Estas cookies recopilan información anónima sobre cómo los visitantes utilizan nuestro sitio web, como las páginas visitadas y los enlaces en los que se hace clic. Estos datos nos ayudan a mejorar el rendimiento del sitio y optimizar la experiencia del usuario.</li>
                        <li><strong>Cookies de funcionalidad:</strong> Estas cookies permiten que el sitio web recuerde tus preferencias y te proporcione características personalizadas. Por ejemplo, pueden recordar tu idioma preferido o tu ubicación geográfica.</li>
                        <li><strong> Cookies de publicidad:</strong> Utilizamos cookies de terceros para mostrar anuncios relevantes en nuestro sitio web y en otros sitios que visites. Estas cookies recopilan información sobre tus actividades en línea, como las páginas que visitas y los productos en los que estás interesado, para adaptar los anuncios a tus intereses.</li>
                    </ul>
                </li>
                <li>
                    <p class="condicion">Control de cookies</p>
                    <p>Puedes controlar y administrar las cookies a través de la configuración de tu navegador. Puedes bloquear o eliminar las cookies existentes y configurar tu navegador para que te avise antes de aceptar nuevas cookies. Sin embargo, ten en cuenta que si desactivas o eliminas las cookies, es posible que algunas funciones de nuestro sitio web no estén disponibles o no funcionen correctamente.</p>
                </li>
                <li>
                    <p class="condicion">Enlaces a terceros</p>
                    <p>Nuestro sitio web puede contener enlaces a otros sitios web de terceros que tienen sus propias políticas de cookies. No nos hacemos responsables del contenido o las prácticas de privacidad de estos sitios. Te recomendamos revisar las políticas de cookies de dichos sitios antes de proporcionarles cualquier información personal.</p>
                </li>
                <li>
                    <p class="condicion">Cambios en la Política de Cookies</p>
                    <p>Nos reservamos el derecho de actualizar o modificar esta Política de Cookies en cualquier momento. Cualquier cambio entrará en vigor inmediatamente después de su publicación en nuestro sitio web. Te recomendamos revisar esta política periódicamente para estar informado sobre cómo utilizamos las cookies.</p>
                </li>
            </ol>
            <p>Si tienes alguna pregunta o inquietud acerca de nuestra Política de Cookies, no dudes en contactar con nosotros.</p>
            <p>Gracias por utilizar nuestro sitio web y confiar en <strong>Books</strong>.</p>
        </div>
    </div>
</div>
@endsection