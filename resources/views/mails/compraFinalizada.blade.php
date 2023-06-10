@extends('layouts.plantilla-email')
@section('content')
    <div class="header" style="background-image: url('https://res.cloudinary.com/det0ae4ke/image/upload/v1685910624/books/email-layout-bg_iorw5x.jpg'); background-position: left center;">
        <span class="title">¡GRACIAS POR TU COMPRA!</span>
    </div>
    <p>¡Hola {{$pedido->user->nombre}}!</p>
    <p>Gracias por confiar en nosotros y por completar tu compra. Nos complace informarte que hemos recibido tu pedido y estamos trabajando diligentemente para procesarlo y prepararlo para su envío.</p>
    <p><strong>Detalles de la compra</strong></p>
    <p style="color: #219250; font-weight: bolder;">[Pedido #{{$pedido->id}}] ({{\Carbon\Carbon::parse($pedido->created_at)->locale('es')->isoFormat('DD [de] MMMM [de] YYYY')}})</p>
    <table border="1">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pedido->libros as $libro)
                <tr>
                    <td>{{$libro->titulo}}</td>
                    <td>{{$libro->pivot->cantidad}}</td>
                    <td>{{$libro->precio}}€</td>
                    <td>{{$libro->pivot->subtotal}}€</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"><strong>Método de pago:</strong></td>
                <td>{{$pedido->tipo_pago}}</td>
            </tr>
            <tr>
                <td colspan="3"><strong>Total:</strong></td>
                <td>{{$pedido->total}}€</td>
            </tr>
        </tfoot>
    </table>
    <p>Si tienes alguna pregunta o necesitas asistencia adicional, no dudes en contactarnos. Estamos aquí para ayudarte en cualquier momento.</p>
    <p>Agradecemos nuevamente tu compra y esperamos que disfrutes de tu(s) producto(s) pronto. Valoramos tu confianza en nuestra empresa y estamos comprometidos a brindarte un excelente servicio.</p>
    <p style="font-weight: bolder; text-align: center;">¡Muchas gracias pos su pedido!</p>
@endsection