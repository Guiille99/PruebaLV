@extends('layouts.plantilla-email')
@section('content')
    <p>¡Hola amante de la lectura!</p>
    <p>Esperamos que te encuentres disfrutando de nuestras recomendaciones literarias y explorando nuevas historias fascinantes. Nos complace informarte que hemos publicado un nuevo post destacado en nuestra librería titulado <strong>{{$post->nombre}}</strong> que seguramente capturará tu interés.</p>
    <p>En Books, nos esforzamos por ofrecerte contenido de calidad que alimente tu pasión por la lectura. Ya sea que busques una novela emocionante, una obra clásica atemporal o un libro informativo que expanda tus horizontes, estamos seguros de que encontrarás algo que se ajuste perfectamente a tus gustos.</p>
    <p>Puedes disfrutar de nuestro nuevo post a través del siguiente enlace: </p>
    <a href="{{route('show.post', $post->slug)}}" class="btn">Ir al nuevo post</a>
    <p>Si tienes alguna pregunta o necesitas asistencia adicional, no dudes en contactarnos. Estamos aquí para ayudarte y asegurarnos de que disfrutes al máximo de tu experiencia de lectura.</p>
    <p>¡Feliz lectura!</p>
@endsection