@extends('layouts.plantilla')
@section('title', 'Cómo darse de baja del Newsletter')
@section('body-class', 'vh-100 d-flex flex-column justify-content-between')
@section('content')
<div class="container flex-grow-1">
    <nav class="pt-3" aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{route('index')}}">Inicio</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="{{route('support')}}">Ayuda</a></li> 
            <li class="breadcrumb-item active" aria-current="page">¿Cómo puedo darme de baja del Newsletter?</li> 
        </ol>
    </nav>
    <div class="info-empresa__container support__container py-3">
        <div class="title__container">
            <h1 class="title">¿Cómo puedo darme de baja del Newsletter?</h1>
        </div>
        <div class="support-answer info__content py-3">
            <p>En <strong>Books</strong> damos la oportunidad a todo el mundo a disfrutar de nuestro Newsletter, sin necesidar de estar suscrito en nuestra web. Por ello, existen dos formas de darse de baja en el Newsletter:</p>
            <ul>
                <ol>
                    <li>
                        <p class="condicion">Si dispones de una cuenta <i>Books </i>:</p>
                        <p>Si tienes una cuenta en <i>Books</i> deberás ir a <i><strong>Perfil > Desuscribirse del Newsletter.</strong></i> A contunuación, deberá introducir su contraseña para verificar que es usted el que desea darse de baja. Una vez hecho esto, se habrá dado de baja de nuestro newsletter correctamente.</p>
                    </li>
                    <li>
                        <p class="condicion">Si no dispones de una cuenta <i>Books </i>:</p>
                        <p>Si no tienes una cuenta en <i>Books</i> deberás ir al enlace <i><strong>Baja del Newsletter</strong></i>, situado en el pie de página. Allí, deberás escribir el correo electrónico suscrito, al cual se le enviará un correo donde se podrá dar de baja de forma segura.</p>
                    </li>
                </ol>
            </ul>
        </div>
    </div>
</div>
@endsection    