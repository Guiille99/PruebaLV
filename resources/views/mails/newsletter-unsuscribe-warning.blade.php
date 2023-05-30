<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
       #delete-newsletter-link{
            display: inline-block;
            padding: 8px 18px;
            background-color: #2d3748;
            color: #fff;
            border-radius: 3px;
            border: none;
            text-decoration: none;
        }
        #delete-newsletter-link:hover{
            background-color: #212a39;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Aviso de baja del Newsletter</h1>
    
    <p>Si ha recibido este mensaje es porque ha solicitado darse de baja en nuestro newsletter.</p>
    <p>Si has sido tú el que ha solicitado la baja, pulsa en el botón que hay en la parte inferior de este mensaje para continuar con el proceso.</p> 
    <p>Si no has sido tú puedes ignorar este mensaje.</p>
    <br><br>
    <a href="{{route('unsuscribeNoAccount.newsletter', [$token, $email])}}" id="delete-newsletter-link">Darse de baja</a>
</body>
</html>