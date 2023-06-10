@extends('layouts.plantilla-email')
@section('content')
<h1>Aviso de baja del Newsletter</h1>
    
<p>Si ha recibido este mensaje es porque ha solicitado darse de baja en nuestro newsletter.</p>
<p>Si has sido tú el que ha solicitado la baja, pulsa en el botón que hay en la parte inferior de este mensaje para continuar con el proceso.</p> 
<p>Si no has sido tú puedes ignorar este mensaje.</p>
<br><br>
<a href="{{route('unsuscribeNoAccount.newsletter', [$token, $email])}}" class="btn">Darse de baja</a>
@endsection