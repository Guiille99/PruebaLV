@extends('layouts.plantilla')
@section('title', 'Books | Política de protección de datos')    
@section('content')
<div class="container">
    <nav class="pt-3" aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{route('index')}}">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Política de protección de datos</li> 
        </ol>
    </nav>
    <div class="info-empresa__container">
        <div class="portada">
            <h1 id="title">POLÍTICA PROTECCIÓN DE DATOS</h1>
        </div>
        <div class="info__content">
            <p>En <strong>Books</strong>, valoramos tu privacidad y nos comprometemos a proteger los datos personales que nos proporcionas a través de nuestro sitio web. Esta Política de Protección de Datos describe cómo recopilamos, utilizamos y protegemos tu información personal. Al utilizar nuestro sitio web, aceptas las prácticas descritas en esta política.</p>
            <ol>
                <li class="mb-3">
                    <p class="condicion">Recopilación de Información</p>
                    <p>Cuando visitas nuestro sitio web, es posible que recopilemos cierta información personal, como tu nombre, dirección de correo electrónico y número de teléfono, solo si decides proporcionarla voluntariamente al comunicarte con nosotros o al realizar una compra. También podemos recopilar información no personal, como datos demográficos y patrones de navegación.</p>
                </li>
                <li class="mb-3">
                    <p class="condicion">Uso de la Información</p>
                    <p>Utilizamos la información personal que recopilamos para los siguientes fines:</p>
                    <ul>
                        <li>Procesar tus pedidos y realizar entregas de productos.</li>
                        <li>Mantenerte informado sobre eventos, promociones y novedades relacionadas con nuestra librería, siempre y cuando hayas dado tu consentimiento expreso.</li>
                        <li>Responder a tus consultas, preguntas o solicitudes de servicio al cliente.</li>
                        <li>Mejorar y personalizar tu experiencia de navegación en nuestro sitio web.</li>
                        <li>Cumplir con las obligaciones legales y reglamentarias aplicables.</li>
                    </ul>
                </li>
                <li class="mb-3">
                    <p class="condicion">Compatir información</p>
                    <p>En <strong>Books</strong>, nos comprometemos a no vender, alquilar o compartir tu información personal con terceros no afiliados, excepto en las siguientes circunstancias:</p>
                    <ul>
                        <li>Con proveedores de servicios de confianza que nos ayudan en la operación de nuestro negocio, como empresas de envío y procesadores de pagos. Estos proveedores están obligados a mantener la confidencialidad de tu información y utilizarla solo para los fines específicos acordados.</li>
                        <li>Si es requerido por ley, para cumplir con procesos legales, responder a solicitudes gubernamentales legítimas o proteger nuestros derechos legales.</li>
                    </ul>
                </li>
                <li class="mb-3">
                    <p class="condicion">Seguridad de los Datos</p>
                    <p>Tomamos medidas razonables para proteger tu información personal contra pérdida, uso indebido y acceso no autorizado. Utilizamos protocolos de seguridad estándar de la industria y tecnologías de encriptación para garantizar la confidencialidad de los datos transmitidos y almacenados.</p>
                </li>
                <li class="mb-3">
                    <p class="condicion">Tus Derechos</p>
                    <p>Tienes derecho a acceder, corregir, actualizar y eliminar tus datos personales que almacenamos. Si deseas ejercer alguno de estos derechos, ponte en contacto con nosotros utilizando los datos de contacto proporcionados al final de esta política.</p>
                </li>
                <li class="mb-3">
                    <p class="condicion">Cambios en la Política de Protección de Datos</p>
                    <p>Podemos actualizar esta Política de Protección de Datos periódicamente para reflejar cambios en nuestras prácticas de privacidad. Te recomendamos revisar esta política regularmente para estar informado sobre cómo protegemos tu información personal.</p>
                </li>
            </ol>
            <p>Si tienes alguna pregunta o inquietud acerca de nuestra Política de Protección de Datos, no dudes en contactarnos a través de los siguientes medios:</p>
            <p><strong>Correo electrónico: books2023.info@gmail.com</strong></p>
            <p><strong>Teléfono: 623456789</strong></p>
            <p>Gracias por confiar en <strong>Books</strong>. Nos comprometemos a proteger tu privacidad y garantizar que tu experiencia de compra sea segura y satisfactoria.</p>
        </div>
    </div>
</div>
@endsection