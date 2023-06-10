@extends('layouts.plantilla')
@section('title', 'Books | Condiciones de uso')    
@section('content')
    <div class="container">
        <nav class="pt-3" aria-label="breadcrumb">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="{{route('index')}}">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Condiciones de uso</li> 
            </ol>
        </nav>
        <div class="condiciones-uso__container info-empresa__container">
            <div class="portada">
                <h1 id="title">CONDICIONES DE USO</h1>
            </div>
            <div class="info__content">
                <p>Bienvenido a <strong>Books</strong> y gracias por visitar nuestra página web. Estas Condiciones de Uso establecen los términos y condiciones que rigen tu acceso y uso de nuestro sitio web. Al acceder o utilizar este sitio web, aceptas cumplir y estar sujeto a estas condiciones. Si no estás de acuerdo con alguna parte de estas condiciones, te recomendamos que no utilices nuestro sitio web.</p>
                <ol>
                    <li>
                        <p class="condicion">Propósito del Sitio Web</p>
                        <p>Nuestro sitio web tiene como objetivo brindar información sobre nuestros productos, servicios, eventos y promociones relacionados con nuestra librería. Nos esforzamos por proporcionar contenido preciso y actualizado, pero no garantizamos la exhaustividad o exactitud de la información presentada. El uso de cualquier información o materiales en este sitio web es bajo tu propio riesgo.</p>
                    </li>
                    <li>
                        <p class="condicion">Propiedad Intelectual</p>
                        <p>Todos los contenidos de este sitio web, incluyendo pero no limitado a texto, gráficos, logotipos, imágenes, videos, audios y software, están protegidos por derechos de propiedad intelectual y leyes de derechos de autor. Estos contenidos son propiedad exclusiva de <strong>Books</strong> o de sus respectivos propietarios. Queda estrictamente prohibida la reproducción, distribución, modificación, exhibición o cualquier otro uso no autorizado de los materiales sin nuestro consentimiento expreso por escrito.</p>
                    </li>
                    <li>
                        <p class="condicion">Enlaces a Terceros</p>
                        <p>Nuestro sitio web puede contener enlaces a sitios web de terceros que son proporcionados únicamente para tu conveniencia. No tenemos control sobre estos sitios web y no nos hacemos responsables de su contenido, políticas de privacidad o prácticas. La inclusión de cualquier enlace no implica necesariamente una asociación, respaldo o aprobación por nuestra parte.</p>
                    </li>
                    <li>
                        <p class="condicion">Privacidad</p>
                        <p>Respetamos tu privacidad y nos comprometemos a proteger la información personal que nos proporciones a través de nuestro sitio web. Consulta nuestra Política de Privacidad para obtener más información sobre cómo recopilamos, utilizamos y protegemos tus datos.</p>
                    </li>
                    <li>
                        <p class="condicion">Limitación de Responsabilidad</p>
                        <p>En la medida permitida por la ley, renunciamos a cualquier responsabilidad por cualquier daño directo, indirecto, incidental, consecuente o especial que pueda surgir del uso de nuestro sitio web, incluso si se nos ha informado de la posibilidad de tales daños.</p>
                    </li>
                    <li>
                        <p class="condicion">Modificaciones</p>
                        <p>Nos reservamos el derecho de modificar estas Condiciones de Uso en cualquier momento sin previo aviso. Te recomendamos que revises periódicamente estas condiciones para estar informado de cualquier cambio. El uso continuado de nuestro sitio web después de la publicación de modificaciones constituye tu aceptación de las mismas.</p>
                    </li>
                </ol>
                <p>Si tienes alguna pregunta o inquietud acerca de estas Condiciones de Uso, no dudes en ponerse en contacto con nosotros a través de los canales de comunicación proporcionados en nuestra página web.</p>
                <p>Gracias por visitar <strong>Books</strong>. ¡Esperamos que disfrutes de tu experiencia en nuestro sitio web y te deseamos una feliz lectura!</p>
            </div>
        </div>
    </div>
@endsection