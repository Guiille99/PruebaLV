<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("title")</title>
    <link rel="shortcut icon" href="{{asset('uploads/logo.ico')}}" type="image/x-icon">
    <script src="{{asset('build/assets/jquery-3.6.3.min.js')}}"></script>
    @vite(["resources/css/app.scss", "resources/js/app.js", "resources/js/validation_form.js"])
</head>
<body>
    @yield('content')
</body>
</html>